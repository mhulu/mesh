<?php 
namespace Star\wechat\biz;

use Star\wechat\biz\BaseBiz;


class User extends BaseBiz
{

    function __construct($token)
    {
        parent::__construct();
        $this->token = $token;
        $this->url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=';
    }

    /**
     * 获取用户列表数据
     * @return array 将json格式解析成数组
     */
    public function getUsers()
    {
         return json_decode(parent::get($this->url.$this->token), true);
    }

}