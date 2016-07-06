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
        // $this->user = new UserRepo(Auth::user());
        $this->user = new UserRepo(Auth::loginUsingId(1, true));
    }

    public function userInfo($id)
    {
        return $this->user->userInfo($id);
    }
    public function mplist()
    {
        $preAuthCode = WeOpen::getPreAuthCode();
        // $preAuthCode = 'aa';
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
        $wxData = WeOpen::getAuthorizerAccessToken($_GET['auth_code']);
        $data = $this->user->bindMp($wxData);
        if ($data) {
            return redirect('/');
        }
    }
    public function delWxmp($id)
    {
        if ($this->user->isTheLastOneInWxmp(Auth::user()->id, $id)) {
            $this->user->deleteWxmp($id);
        }
            $this->user->detachWxmp($id);
    }
}
