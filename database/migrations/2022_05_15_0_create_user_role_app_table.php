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
        Schema::create('user_role_app', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')     ->unsigned()->index();
            $table->integer('roles_app_id')->unsigned()->index();
            
            $table->foreign('roles_app_id')->references('id')->on('roles_app') ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')     ->references('id')->on('users')     ->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('user_role_app');
    }
};
