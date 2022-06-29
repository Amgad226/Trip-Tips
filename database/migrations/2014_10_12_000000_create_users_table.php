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
            $table->integer('level')->default(0);
            $table->string('img')->nullable();
            $table->string('password_token')->nullable();
            $table->string('verifay_code')->nullable();
            $table->boolean('is_verifaied')->default(false);
            $table->integer('role_id')->default(1)->unsigned()->index();
            // $table->boolean('wallet_id')->unsigned()->index();;
            
            //->unsigned()->index();
            $table->timestamp('email_verified_at')->nullable();
            
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
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
