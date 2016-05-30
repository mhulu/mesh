<?php

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
        factory(App\App::class, 3)
                ->create()
                ->each(function ($i) {
                        $i->wxmps()->attach(factory(App\Wxmp::class)->create());
                });

    }
}
