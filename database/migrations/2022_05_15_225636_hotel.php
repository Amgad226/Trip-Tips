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
        Schema::create('hotel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable();
            $table->string('name_EN')->nullable();
            $table->string('name_AR')->nullable();
            $table->integer('rate')->nullable();
            $table->string('location')->nullable();
            $table->integer('Payment')->nullable();
            $table->integer('price_calss_A')->nullable();
            $table->integer('price_calss_B')->nullable();
            $table->string('support_email')->nullable();
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
        Schema::dropIfExists('hotel');
    }
};
