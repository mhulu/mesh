<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = factory(Star\Permission\Models\Permission::class, 3)
                ->create()
                ->each(function ($i) {
                        $i->roles()->attach(factory(Star\Permission\Models\Role::class)->create());
                });

    }
}
