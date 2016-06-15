<?php
// header('Access-Control-Allow-Origin: *');
// header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

// 服务类 如发送短信
Route::group(['prefix' => 'service'], function () {
    Route::post('sendSms', 'SMSController@fire');
});

// 微信第三方平台
Route::group(['middleware' => ['api']], function () {
    Route::any('/auth', 'WechatController@auth');
    Route::get('/api/callback', 'Api\v1\HomeController@callback');
});

// Route::get('/', function () {
//     return redirect('home');
// });

Route::auth();

// 应用
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@home');
});

// api
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['middleware' => 'auth'], function ($api) {
    $api->get('mplist', 'App\Http\Controllers\Api\v1\HomeController@mplist');
    $api->get('wxmp/{id}', 'App\Http\Controllers\Api\v1\HomeController@userInfo');
});
// 产品中加入 'middleware' => 'auth'
// Route::group(['prefix' => 'api/'], function () {
//     Route::get('wxmp/{id}', 'Api\v1\HomeController@userInfo');
//     Route::get('mplist', 'Api\v1\HomeController@mplist');
//     Route::get('menu', 'Api\v1\HomeController@menu');
// });
//对外验证接口
Route::post('auth/findpass', 'Auth\AuthController@passReset');
// 超级管理
Route::group(['prefix' => 'god', 'middleware'=>'acl:admin'], function () {
    Route::get('app', 'God\AppController@index');
});
