<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home/mplist';
    protected $username = 'mobile';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->messages =  [
            'mobile.required' => '请填写手机号码',
            'mobile.unique' => '该手机已经注册,请直接登陆',
            'authCode.required' => '请填写短信验证码',
            'authCode.in' => '短信验证码不正确',
            'password.required' => '请输入您的密码',
            'password.confirmed' => '两次输入的密码不一致'
        ];
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $authCode = Cache::get($data['mobile']);
        $validator = Validator::make($data, [
            'mobile' => 'required|unique:users',
            'authCode' => 'required|in:'.$authCode,
            'password' => 'required|min:6|confirmed',
        ], $this->messages);
        return $validator;
    }

    /**
     * 验证码通过后,重置密码
     * @param  Request $request 
     */
    protected function passReset(Request $request)
    {
        $data = $request->all();
        $authCode = Cache::get($data['mobile']);
        $validator = Validator::make($data, [
            'mobile' => 'required',
            'authCode' => 'required|in:'.$authCode,
            'password' => 'required|min:6|confirmed',
        ], $this->messages);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        User::where('mobile', $request->mobile)
                    ->update(['password' => bcrypt($request['password'])]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
