<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('facilities_id')->unsigned()->index();
            $table->integer('id_the_e');


            $table->foreign('role_id')      ->references('id')->on('roles')     ->onDelete('cascade')->onUpdate('cascade');           
            $table->foreign('user_id')      ->references('id')->on('users')     ->onDelete('cascade')->onUpdate('cascade');          
            $table->foreign('facilities_id')->references('id')->on('facilities')->onDelete('cascade')->onUpdate('cascade');          
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
        Schema::dropIfExists('roles_users');
    }
};
