<?php 
namespace Star\Repositories\WeChat;

use Base;
class User extends Base
{
    /**
     * 获取用户列表数据
     * @return array 将json格式解析成数组
     */
    public static function getUsers($token)
    {
          json_decode(get('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token), true);
    }

     public static  function getUserDetail($uid)
    {
        return json_decode(get('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$uid.'&lang=zh_CN'));
    }
}