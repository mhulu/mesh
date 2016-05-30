<?php

use Illuminate\Database\Seeder;

class WxmpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wxmps = factory(App\Wxmp::class, 3)
                ->create()
                ->each(function ($i) {
                        $i->users()->attach(factory(App\User::class)->create());
                });

    }
}
