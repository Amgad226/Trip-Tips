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
        Schema::create('package_restaurants', function (Blueprint $table) {
            $table->increments('id');
         
            $table->integer('restaurant_id')->unsigned()->index();   
            $table->integer('package_id')->unsigned()->index();

            // $table->timestamps('end_date')->nullable();
            $table->timestamp('restaurant_booking_date');

            $table->foreign('package_id')   ->references('id')->on('packages')  ->onDelete('cascade') ->onUpdate('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');

            
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
        Schema::dropIfExists('package_restaurants');
    }
};
