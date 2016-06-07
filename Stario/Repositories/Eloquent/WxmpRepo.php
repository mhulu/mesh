<?php 
namespace Star\Repositories\Eloquent;

use App\Wxmp;
use Star\Repositories\Contracts\InterfaceWxmp;

/**
* 微信公众号接口Eloquent实现类
*/
class WxmpRepo implements InterfaceWxmp
{
    protected $wxmp;
    public function __construct()
    {
        $this->wxmp = new Wxmp;
    }
    public function has($appId)
    {
        return $this->wxmp->where('appId', $appId)->first();
    }
    public function create($data)
    {
        return $this->wxmp->create($data);
    }
}
