<?php 
namespace Star\Api;

use App\Http\Controllers\Controller;
use Star\Repositories\WeChat\User;

class WxUserController extends Controller
{
    
    public function index($token, $perpage = 10)
    {
        $raw = User::init($token)->getUsers($token);
        dd($raw);
        if (empty($raw['data'])) {
            return $raw;
        }
        return $this->getUserDetail($raw['data']['openid']);
    }

    /**
     * 获取用户详细资料
     * @param  array $users 微信原始的用户openid列表
     * @param int $start 从哪一条记录开始遍历
     * @param int $perpage 遍历的条数
     * @return [type]        [description]
     */
    private function getUserDetail(array $users, $start = 0, $perpage = 10)
    {
        $collection = collect($users);
        $collection->map(function($item){
            return User::getUserDetail($item);
        });
        return $collection->all();
    }

    public function show($token)
    {
        $biz = new User($token);
    }

}