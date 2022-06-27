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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->integer('level');
            $table->string('img');
            $table->integer('password_token')->nullable();
            $table->string('verifay_code')->nullable();
            $table->boolean('is_verifaied')->defalte(0);
            $table->integer('role_id')->nullable();
            $table->boolean('wallet_id')->nullable();
            
            //->unsigned()->index();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
