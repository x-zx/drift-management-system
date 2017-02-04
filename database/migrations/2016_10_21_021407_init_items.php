<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamp('expired_at')->useCurrent();
            $table->integer('owner_user_id')->unsigned();
            $table->integer('holder_user_id')->unsigned();
            $table->string('des');
            $table->text('photo');
            $table->boolean('transfer');
            $table->boolean('shelves');
            $table->string('code');
            $table->timestamps();
            // $table->foreign('owner_user_id')->references('id')->on('users');
            // $table->foreign('holder_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
