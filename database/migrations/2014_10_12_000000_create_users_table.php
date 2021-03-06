<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
             $table->increments('id');
             $table->string('mobile', 12)->unique();
             $table->string('name');
             $table->string('email');
             $table->string('password');
             $table->boolean('active')->default(1);
             $table->string('avatar')->nullable;
             $table->rememberToken();
             $table->timestamp('last_login');
             $table->string('last_ip',45);
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
