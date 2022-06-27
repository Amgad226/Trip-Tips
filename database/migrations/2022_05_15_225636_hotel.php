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
            $table->integer('category_id');
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->integer('rate');
            $table->string('location');
            $table->integer('Payment');
            $table->integer('price_calss_A');
            $table->integer('price_calss_B');
            $table->string('support_email');
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
