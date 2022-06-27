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
        Schema::create('package', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_en');
            $table->string('name_ar') ->nullable() ;
            $table->integer('price')  ->nullable() ;
            $table->integer('number_of_reservation')->default(0);

            $table->integer('hotel_id')->unsigned()->index();
            $table->integer('airplane_id')->unsigned()->index();
            $table->integer('restaurant_id')->unsigned()->index();
            
            $table->integer('tourist_supervisor_id')->nullable();
           
            $table->timestamps();


            $table->foreign('hotel_id')     ->references('id')->on('hotel')     ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('airplane_id')  ->references('id')->on('airplane')  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurant')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package');
    }
};
