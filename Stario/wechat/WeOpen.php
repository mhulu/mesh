<?php
    namespace Star\wechat;

    use GuzzleHttp\Client;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;
    use Star\wechat\support\AES;
    use Star\wechat\support\XML;

class WeOpen
{
    public static $client;
    public static $appId;
    public static $secureKey;
    public static $token;
    public static $aeskey;

    /**
   * STEP 1:获取微信推送信息，通常有以下几种情况：
   * 1.推送ComponentVerifyTicket
   * 2.推送InfoType(授权成功、取消授权、更新授权列表)
   */
    public static function getWxPostData()
    {
        //微信发送过来的URL参数,供解密使用
        $nonce = $_GET['nonce'];
        $timestamp = $_GET['timestamp'];
        $msgSignature = $_GET['msg_signature'];
        Cache::forever('nonce', $nonce);
        Cache::forever('timestamp', $timestamp);
        Cache::forever('msgsignature', $msgSignature);

        $rawPostData             = file_get_contents("php://input");
        $encrypt                 = XML::parse($rawPostData)['Encrypt'];
        $rebuild                 = XML::build(['ToUserName'=>'toUser','Encrypt'=>$encrypt]);
        $pc  = new AES(self::$aeskey, self::$appId, self::$token);
        $decryptedMsg            = $pc->decode($rebuild);
        $result = XML::parse($decryptedMsg);
        // 如果是ComponentVerifyTicket则写入缓存
        if (!empty($result['ComponentVerifyTicket'])) {
            Cache::forever('wx_ticket', $result['ComponentVerifyTicket']);
        }
        return $result;
    }

    /**
    * STEP 2:获取component_access_token
    * 该令牌有效期2小时，并且调用不是无限制的，所以需要每隔2小时前刷新一下
    */
    public static function getComponenAccessToken()
    {
        if (empty (Cache::get('wx_ticket'))) {
            return 'Please wait 10 minutes.';
        }
        $ticket = Cache::get('wx_ticket');
        $uri = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
        $result = self::$client->post($uri, ['json'=>["component_appid" => self::$appId,
                "component_appsecret" => self::$secureKey,
                "component_verify_ticket" => $ticket
            ]]);
        $data = json_decode($result->getBody());
        Cache::forever('wx_component_access_token', $data->component_access_token);
    }

    /**
     * STEP 3:获取预授权码，存入缓存
     */
    public static function getPreAuthCode()
    {
        $component_access_token = Cache::get('wx_component_access_token');
        if (empty ($component_access_token)) {
            self::getComponenAccessToken();
        }
        $uri = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token='
                    .$component_access_token;
        $result = self::$client->post($uri, ['json'=>["component_appid" => self::$appId]]);
        $data = json_decode($result->getBody());
        if (empty($data->pre_auth_code)) {
            self::getComponenAccessToken();
        } else {
            $preAuthCode = $data->pre_auth_code;
            Cache::forever('wx_preAuthCode', $preAuthCode);
            return $preAuthCode;
        }

    }
    /**
     * STEP 4: 换取authorizer_access_token和authorizer_refresh_token
     */
    public static function getAuthorizerAccessToken($authcode)
    {
        $componentAccessToken = Cache::get('wx_component_access_token');
        if (empty($componentAccessToken)) {
             self::getComponenAccessToken();
        }
         $uri = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token='
                    .Cache::get('wx_component_access_token');

        $result = self::$client->post($uri, ['json'=>[
                "component_appid" => self::$appId,
                "authorization_code" => $authcode
                ]]);
        return  json_decode($result->getBody());
    }

    //使用authorizer_refresh_token刷新authorizer_access_token
    public static function refreshAuthorizeToken($appId, $refreshToken)
    {
        $uri = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token='
                    .Cache::get('wx_component_access_token');
        $result = self::$client->post($uri, ['json'=>[
                "component_appid" => self::$appId,
                //TODO 下面两个替换，已经不在缓存中了
                "authorizer_appid" => $appId,
                "authorizer_refresh_token" => $refreshToken
                ]]);
        return json_decode($result->getBody());
        // Cache::forever('wx_authorizer_access_token', $data->authorizer_access_token);
    }

    /**
     * 根据传入的appID来获取公众号的基本信息
     */
    public static function fetchInfo($appId)
    {
        $uri = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token='
                    .Cache::get('wx_component_access_token');

        $result = self::$client->post($uri, ['json'=>[
                "component_appid" => self::$appId,
                "authorizer_appid" => $appId,
                ]]);
         return json_decode($result->getBody());
    }
    
    public function fetchOptionInfo($optionName)
    {
        $uri = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_option?component_access_token'
                    .Cache::get('wx_component_access_token');

        $result = self::$client->post($uri, ['json'=>[
                "component_appid" => self::$appId,
                "authorizer_appid" => Cache::get('wx_authorizerAppId'),
                "option_name" => $optionName
                ]]);
    }
}
    WeOpen::$client = new Client;
    WeOpen::$appId = config('wechat.app_id');
    WeOpen::$secureKey  = config('wechat.secret');
    WeOpen::$token  = config('wechat.token');
    WeOpen::$aeskey = config('wechat.aes_key');

