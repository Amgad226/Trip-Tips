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
        Schema::create('package_places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id')->unsigned()->index();
            $table->integer('place_id')->unsigned()->index();

            $table->dateTime('place_booking');
   
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('place_id')  ->references('id')->on('places')  ->onDelete('cascade')->onUpdate('cascade');
            
            // $table->timestamp("hotel_booking_date");
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_places');
    }
};
