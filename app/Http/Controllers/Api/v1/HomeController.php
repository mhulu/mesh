<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Wxmp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Star\Repositories\Eloquent\UserRepo;
use Star\Repositories\Eloquent\WxmpRepo;
use Star\wechat\WeOpen;

class HomeController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = new UserRepo(Auth::user());
        // $this->user = new UserRepo(Auth::loginUsingId(1, true));
    }

    public function userInfo($id)
    {
        return $this->user->userInfo($id);
    }
    public function mplist()
    {
        $preAuthCode = WeOpen::getPreAuthCode();
        $url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid='
                        .config('wechat.app_id').'&pre_auth_code='
                        .$preAuthCode.'&redirect_uri='
                        .config('wechat.redirect_url');
        return response()->json([
                    'url' =>$url,
                    'mplist' => $this->user->wxmps()
            ], 200);
    }

    public function menu()
    {
        return $this->user->menu();
    }

    public function callback()
    {
        // $wxData = WeOpen::getAuthorizerAccessToken($_GET['auth_code']);
        // $this->user->bindMp($wxData);
        // TODO
        // 1. 如果顺利获得上面的数据，返回一个视图
        // 2.该视图提示正在同步数据，其时将数据入库
        // 3.显示按钮，点击根据ID进入后台
        $expiresAt = Carbon::now()->addMinutes(118)->toRfc2822String();
        $cookie_name = uniqid();
        $cookie_value = bcrypt(time() + 715);
        \Cache::put($cookie_name, $cookie_value, $expiresAt);
        return response()->json([
            'cookie_name' => $cookie_name,
            'cookie_value' =>  $cookie_value,
            'cookie_expires' => $expiresAt
        ]);
    }
}
