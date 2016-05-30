<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // protected $toTruncate = ['users'];

    public function run()
    {
        Model::unguard();
        $this->call(PermissionsTableSeeder::class);
        $this->call(AppsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(WxmpsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
