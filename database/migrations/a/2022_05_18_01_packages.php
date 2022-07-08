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
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('price')     ;
            $table->integer('number_of_reservation')->default(0);

            $table->integer('hotel_id')             ->unsigned()->index();
            $table->integer('airplane_id')          ->unsigned()->index();
            $table->integer('restaurant_id')        ->unsigned()->index();
            $table->integer('tourist_supervisor_id')->unsigned()->index();
            
           
            $table->timestamps();


            $table->foreign('hotel_id')             ->references('id')->on('hotels')              ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('airplane_id')          ->references('id')->on('airplanes')           ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('restaurant_id')        ->references('id')->on('restaurants')         ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tourist_supervisor_id')->references('id')->on('tourist_supervisors')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
};
