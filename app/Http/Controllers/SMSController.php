<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Star\sms\MakeSMS;
use Star\sms\proxy\BechSmsProxy;

class SMSController extends Controller
{
    /**
 * 发送短信
 * @param  Request $request [前端传过来的请求]
 * 如果request的referer为 /password/reset 请求则不验证
 * 否则会验证手机号码是否已经注册
 */
    public function fire(Request $request)
    {
        preg_match('/\b\/.+/', $request->header('referer'), $matches);
        if($matches[0] == '/password/reset'){
            $mobile = $request['mobile'];
            $content = new MakeSMS;
            $fire = new BechSmsProxy($mobile, $content->makeCode($mobile));
            return $fire->fire(); 
        } else {
            $messages = [
                 'mobile.required' => '请填写手机号码',
                 'mobile.unique' => '该手机已经注册,请直接登陆'
            ];
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|unique:users'
                ], $messages);
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            $mobile = $request['mobile'];
            $content = new MakeSMS;
            $fire = new BechSmsProxy($mobile, $content->makeCode($mobile));
            return $fire->fire();
        }
    }
}
