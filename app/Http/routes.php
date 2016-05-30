<?php

// 服务类 如发送短信
Route::group(['prefix' => 'service'], function () {
    Route::post('sendSms', 'SMSController@fire');
});

// 微信第三方平台
Route::group(['middleware' => ['api']], function () {
    Route::any('/auth', 'WechatController@auth');
    Route::get('/callback', 'Api\v1\HomeController@callback');
});

// Route::get('/', function () {
//     return redirect('home/mplist');
// });

Route::auth();

// 应用
Route::group(['prefix' => 'home', 'middleware' => 'auth'], function () {
    Route::get('mplist', 'HomeController@mplist');
});

// api
Route::group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () {
    Route::post('me', 'Api\v1\HomeController@userInfo');
    Route::get('mplist', 'Api\v1\HomeController@mplist');
    Route::get('menu', 'Api\v1\HomeController@menu');
});
//对外验证接口
Route::post('auth/findpass', 'Auth\AuthController@passReset');
// 超级管理
Route::group(['prefix' => 'god', 'middleware'=>'acl:admin'], function () {
    Route::get('app', 'God\AppController@index');
});
