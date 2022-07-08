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
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->integer('level')->default(0);
            $table->string('img')->nullable();
            $table->string('password_token')->nullable();
            $table->boolean('is_verifaied')->default(false);
            $table->boolean('is_registered')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('have_facilities')->default(0);
            
            
            $table->integer('role_person_id')->default(1)->unsigned()->index();
            $table->foreign('role_person_id')->references('id')->on('roles_person')->onDelete('cascade')->onUpdate('cascade');
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
