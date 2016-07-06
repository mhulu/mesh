<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
       // 父级菜单
            [
            'name' => '微信功能',
            'url' => 'features',
            'icon' => 'th',
            'description' => '微信公众号日常功能',
            'app_id' => 1,
            'parent_id' => 0
            ],
            [
            'name' => '微信管理',
            'url' => 'management',
            'icon' => 'inbox',
            'description' => '微信公众号的日常管理',
            'app_id' => 1,
            'parent_id' => 0
            ],
            [
            'name' => '微信统计',
            'url' => 'stat',
            'icon' => 'area-chart',
            'description' => '微信相关统计信息',
            'app_id' => 1,
            'parent_id' => 0
            ],
        // 子级菜单
        //第一梯队
            [
            'name' => '群发功能',
            'url' => 'mass-send',
            'icon' => 'reply_all',
            'description' => '群发功能',
            'app_id' => 1,
            'parent_id' => 1
            ],
            [
            'name' => '自动回复',
            'url' => 'auto-reply',
            'icon' => 'reply',
            'description' => '自动回复',
            'app_id' => 1,
            'parent_id' => 1
            ],
            [
            'name' => '自定义菜单',
            'url' => 'custom-menu',
            'icon' => 'th-list',
            'description' => '自定义菜单',
            'app_id' => 1,
            'parent_id' => 1
            ],
            [
            'name' => '投票管理',
            'url' => 'vote',
            'icon' => 'fa-thumbs-o-up',
            'description' => '投票管理',
            'app_id' => 1,
            'parent_id' => 1
            ],
         
            // 第三梯队
            [
            'name' => '用户分析',
            'url' => 'user-analysis',
            'icon' => 'male',
            'description' => '用户分析',
            'app_id' => 1,
            'parent_id' => 3
            ],
            [
            'name' => '图文分析',
            'url' => 'app-analysis',
            'icon' => 'pie-chart',
            'description' => '图文分析',
            'app_id' => 1,
            'parent_id' => 3
            ],
            [
            'name' => '菜单分析',
            'url' => 'menu-analysis',
            'icon' => 'bar-chart',
            'description' => '菜单分析',
            'app_id' => 1,
            'parent_id' => 3
            ],
            [
            'name' => '消息分析',
            'url' => 'message-analysis',
            'icon' => 'fa-file-audio-o',
            'description' => '消息分析',
            'app_id' => 1,
            'parent_id' => 3
            ]
        ];
        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
