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
        Schema::create('hotel_booking', function (Blueprint $table) {
            $table->increments('id');
  
            $table->integer('number_of_people');
            $table->integer('number_of_room');
            $table->integer('price');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('note')   ->nullable();
            $table->boolean('by_packge')->nullable();

            // $table->integer('img_qr')           ->nullable();
            // $table->integer('id_your_chois')    ->nullable();

            $table->timestamp('time')->useCurrent = true;

            $table->integer('hotel_id')      ->unsigned()->index();
            $table->integer('hotel_class_id')->unsigned()->index();
            $table->integer('user_id')       ->unsigned()->index();

            $table->foreign('user_id' )      ->references('id')->on('users')       ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hotel_id')      ->references('id')->on('hotels')      ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hotel_class_id')->references('id')->on('hotel_classes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_booking');
    }
};
