<?php 
namespace Star\Repositories\WeChat;

use GuzzleHttp\Client;
use Star\Repositories\WeChat\Base;
class User
{
    static private $client;
    static private $token;

    public static function init($token)
    {
        self::$client = new Client();
        self::$token = $token;
    }
    /**
     * 获取用户列表数据
     * @return array 将json格式解析成数组
     */
    public static function getUsers($token)
    {
          return json_decode(self::get('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token), true);
    }

     public static  function getUserDetail($uid)
    {
        return json_decode(self::get('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.self::$token.'&openid='.$uid.'&lang=zh_CN'));
    }

    private static function get($url)
    {
        $res = self::$client->request('GET', $url);
        return $res->getBody();
    }
}
