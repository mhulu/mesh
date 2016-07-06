<?php
namespace Star\Repositories\WeChat;

use GuzzleHttp\Client;
/**
*   
*/
abstract class Base
{
    protected  $client;
    protected $app;

    public function __construct()
    {
        $this->client = new Client();
    }
    public  function get($url)
    {
        $res = $this->client->request('GET', $url);
        return $this->res->getBody();
    }
}
