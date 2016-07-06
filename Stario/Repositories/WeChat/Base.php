<?php
namespace Star\Repositories\WeChat;

use GuzzleHttp\Client;
/**
*   
*/
 class Base
{
    public static $client;
    protected $app;

    public static function get($url)
    {
        $res = self::$client->request('GET', $url);
        return $res->getBody();
    }
}
Base::$client = new Client;
