<?php

header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');

// 服务类 如发送短信
Route::group(['prefix' => 'service'], function () {
    Route::post('sendSms', 'SMSController@fire');
});

// 微信第三方平台
Route::group(['middleware' => ['api']], function () {
    Route::any('/auth', 'WechatController@auth');
    Route::get('/callback', 'Api\v1\HomeController@callback');
});

Route::auth();

// 应用
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@home');
});

// 产品中加入 'middleware' => 'auth'
Route::group(['prefix' => 'api/'], function () {
    Route::get('wxmp/{id}', '\Star\Api\HomeController@userInfo');
    Route::delete('wxmp/{id}', '\Star\Api\HomeController@delWxmp');
    Route::get('mplist', '\Star\Api\HomeController@mplist');
    Route::get('menu', '\Star\Api\HomeController@menu');
    Route::get('wxToken/{id}', '\Star\Api\WechatController@getToken');
    // Route::resource('wxUser/{token}', '\Star\Api\WxUserController');
});
//对外验证接口
Route::post('auth/findpass', 'Auth\AuthController@passReset');
// 超级管理
Route::group(['prefix' => 'god', 'middleware'=>'acl:admin'], function () {
    Route::get('app', 'God\AppController@index');
});
