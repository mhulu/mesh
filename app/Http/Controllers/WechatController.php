<?php

namespace App\Http\Controllers;

use App\Jobs\WxAuthorization;
use Carbon\Carbon;
use Star\Repositories\Eloquent\WxmpRepo;
use Star\wechat\WeOpen;

class WechatController extends Controller
{
    protected $wxmp;
    function __construct(WxmpRepo $wxmp)
    {
        $this->wxmp = $wxmp;
    }

    // 接收来自微信发送过来的信息，解密获取ticket，并缓存['wx_ticket']
    public function auth()
    {
        $result = WeOpen::getWxPostData();
        if (empty($result['ComponentVerifyTicket'])) {
            $wxmp = $this->wxmp->has('appId', $result['AuthorizerAppid']);
            $this->dispatch(new WxAuthorization($wxmp, $result['InfoType']));
        }
    }

    /**
     * 返回数据库中存储的公众号Token
     * 如果expires小于当前时间，则刷新
     * @param  [int] $id 数据库中公众号ID
     */
    public function getToken($id)
    {
        $wxmp = $this->wxmp->has('id', $id);
        $token = $wxmp->token;
        //正常情况下，refresh_token不会失效，如有错误需要用户从头授权
        //这里没有加验证
        $refreshToken = $wxmp->refresh_token;
        $expires = $wxmp->expires;
        if (time() > strtotime($expires)) {
            return $this->refreshToken($id, $refreshToken);
        } else {
            return response()->json([
                    'token' => $token,
                    'expires' => $wxmp->expires
                ], 200);
        }
    }
    /**
     * 刷新公众号的令牌
     * @param  [int] $id           公众号ID
     * @param  [string] $refreshToken 数据库中该公众号的刷新令牌
     * @return [json]               返回供前台调用
     */
    private function refreshToken($id, $refreshToken)
    {
        $wxmp = $this->wxmp->has('id', $id);
        $result = WeOpen::refreshAuthorizeToken($wxmp->appId, $refreshToken);
        $wxmp->update([
                        'token' => $result->authorizer_access_token,
                        'refresh_token' => $result->authorizer_refresh_token,
                        'expires' => Carbon::now()->addSeconds($result->expires_in - 300)->toDateTimeString()
                        ]);
        return response()->json([
                'token' => $wxmp->token,
                'expires' => $wxmp->expires
            ], 200);
    }
}
