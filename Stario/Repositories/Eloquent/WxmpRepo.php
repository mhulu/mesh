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
    public function has($column, $val)
    {
        return $this->wxmp->where($column, $val)->first();
    }
    public function create($data)
    {
        return $this->wxmp->create($data);
    }
    public function update($data)
    {
        return $this->wxmp->update($data);
    }
    public function getId($column, $val)
    {
        return $this->wxmp->where($column, $val)->first()->id;
    }
    public function destroy($uid)
    {
        return $this->wxmp->users()->detach($uid);
    }
}
