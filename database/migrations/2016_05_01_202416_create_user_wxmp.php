<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWxmp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wxmp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wxmp_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->index(['wxmp_id', 'user_id'])->unique();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_wxmp');
    }
}
