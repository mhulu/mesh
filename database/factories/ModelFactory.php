<?php
use Faker\Factory as Faker;

$factory->define(App\Menu::class, function ($faker) {
    $faker = Faker::create('zh_CN');
    return [
        'name' => $faker->randomElement($array = array('微信功能','微信管理','微信统计','微信设置')),
        'url' => $faker->randomElement($array = array('home','message','app','settings')),
        'icon' => $faker->randomElement($array = array('archive', 'area-chart', 'bell', 'cog', 'cogs', 'dashboard', 'cubes', 'inbox', 'life-ring', 'key')),
        'description' => $faker->sentence,
        'parent_id' => $faker->numberBetween($min = 0, $max = 2),
        'app_id' => factory(App\App::class)->create()->id
    ];
});

$factory->define(App\App::class, function ($faker) {
     $faker = Faker::create('zh_CN');
    return [
        'name' => $faker->randomElement($array = array('微信平台','微网站','医疗数据','舆情应用')),
        'price' => $faker->randomElement($array = array(0, 500, 1000, 5000)),
        'icon' => $faker->randomElement($array = array('archive', 'area-chart', 'bell', 'cog', 'cogs', 'dashboard', 'cubes', 'inbox', 'life-ring', 'key')),
        'description' => $faker->paragraph
    ];
});

$factory->define(App\Message::class, function ($faker) {
     $faker = Faker::create('zh_CN');
    return [
        'body' => $faker->paragraph,
        'type' => $faker->randomElement($array = array('0', '1', '2', '3')),
        'read' => $faker->randomElement($array = array(true, false)),
        'user_id' => factory(App\User::class)->create()->id
    ];
});

$factory->define(App\Wxmp::class, function ($faker) {
     $faker = Faker::create('zh_CN');
    return [
        'appId' => $faker->sha1,
        'name' => $faker->word,
        'nickname' => $faker->company,
        'authorized' => $faker->randomElement($array = array(true, false)),
        'token' => $faker->sha1,
        'refresh_token' => $faker->sha1,
        'avatar_url' => $faker->url,
        'qr_url' => $faker->url
    ];
});

$factory->define(Star\Permission\Models\Role::class, function ($faker) {
    return [
        'name' => $faker->randomElement($array = array('admin','user','vip','advanced')),
        'label' => $faker->randomElement($array = array('管理员','标准用户','VIP','高级用户')),
        'description' => $faker->randomElement($array = array('拥有最高权限','可以管理自己的资源','可以管理自己的资源','可以管理自己的资源')),
    ];
});

$factory->define(Star\Permission\Models\Permission::class, function ($faker) {
    return [
        'name' => $faker->randomElement($array = array('edit','root','view','delete')),
        'label' => $faker->randomElement($array = array('编辑','管理','查看','删除')),
        'description' => $faker->randomElement($array = array('拥有最高权限','可以管理自己的资源','可以管理自己的资源','可以管理自己的资源')),
    ];
});

$factory->define(App\User::class, function ($faker) {
     $faker = Faker::create('zh_CN');
    return [
        'name' => $faker->name,
        'mobile' => $faker->phoneNumber,
        'email' => $faker->email,
        'password' => bcrypt('partooa')
    ];
});