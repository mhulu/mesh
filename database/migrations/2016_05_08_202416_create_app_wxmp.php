<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppWxmp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_wxmp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->unsigned();
            $table->integer('wxmp_id')->unsigned();
            $table->timestamp('deadline')->default('2030-01-01 00:00:01'); //过期时间
            $table->bigInteger('price')->default(0);//每年的价格
            $table->boolean('actived')->nullable();
            $table->index(['app_id', 'wxmp_id'])->unique();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_wxmp');
    }
}
