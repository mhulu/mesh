<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /**
       * User表播种,其中包含roles(已在permission中播撒)和wxmps以及与其关联的pivot表(不需要再播)
       * @var [type]
       */
        $users = factory(App\User::class, 3)
                                            ->create()
                                            ->each(function ($u) {
                                              $u->roles()->attach(factory(Star\Permission\Models\Role::class)->create());
                                              $u->wxmps()->attach(factory(App\Wxmp::class)->create());
                                            });
    }
}
