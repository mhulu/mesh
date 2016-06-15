<?php

use App\App;
use Illuminate\Database\Seeder;

class AppsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app = App::create([
            'name' => '微信管理',
            'description' => '微信公众号的日常管理工作',
            'icon' => 'wechat'
        ]);
    }
}
