<?php

use App\User;
use Illuminate\Database\Seeder;
use Star\Permission\Models\Permission;
use Star\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin',
           'label' => '管理员',
            'level' => 99
        ]);
        $premium = Role::create([
            'name' => 'premium',
            'label' => '超级用户',
            'level' => 2
        ]);

        $user = Role::create([
            'name' => 'user',
            'label' => '标准用户',
            'level' => 1
        ]);

        $user1 = User::create([
            'name' => 'admin',
            'mobile' => '18666778899',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
          ]);

        $root = Permission::create([
            'name' => 'root',
            'label' => '管理员权限'
        ]);
        $editor =  Permission::create([
            'name' => 'update',
            'label' => '修改权限',
        ]);
        $del = Permission::create([
            'name' => 'delete',
            'label' => '删除权限',
          ]);

        $admin->givePermissionTo($root);
        $user1->assignRole($admin);
    }
}
