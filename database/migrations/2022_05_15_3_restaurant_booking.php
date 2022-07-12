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
        Schema::create('restaurant_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned()->index();
            $table->integer('user_id')      ->unsigned()->index();

            $table->integer('number_of_people');
            $table->integer('price')        ;
            $table->timestamp('booking_date');

            // $table->integer('id_your_chois')    ->nullable();
            // $table->integer('img_qr')           ->nullable();
            

            // $table->timestamps();
            $table->timestamp('time')->useCurrent = true;


            $table->foreign('user_id')      ->references('id')->on('users')     ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_booking');
    }
};
