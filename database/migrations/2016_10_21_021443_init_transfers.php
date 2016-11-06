<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitTransfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->integer('from_user_id')->unsigned();
            $table->integer('to_user_id')->unsigned();
            $table->string('trans_way');
            $table->timestamp('trans_at');
            $table->boolean('accept');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('form_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('init_transfers');
    }
}
