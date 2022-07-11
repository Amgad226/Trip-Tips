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
        Schema::create('package_hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->unsigned()->index();
            $table->integer('class_hotel_id')->unsigned()->index();

            $table->integer('package_id')->unsigned()->index();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
            


            $table->foreign('class_hotel_id')->references('id')->on('hotel_classes')->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('hotel_id')      ->references('id')->on('hotels')       ->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('package_hotels');
    }
};
