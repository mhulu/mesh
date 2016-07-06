<?php
namespace Star\wechat\biz;

use GuzzleHttp\Client;
/**
*   
*/
class BaseBiz
{
    protected  $client;
    protected $app;
    protected $url;

    public function __construct()
    {
        $this->client = new Client();
    }
    public  function get($url)
    {
        $res = $this->client->request('GET', $url);
        return $res->getBody();
    }
}
