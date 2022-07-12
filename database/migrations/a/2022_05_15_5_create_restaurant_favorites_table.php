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
        Schema::create('restaurant_favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_rest_fav');
           
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('resturant_id')->unsigned()->index();
            $table->foreign('resturant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
            
            // $table->timestamps();
            $table->timestamp('time')->useCurrent = true;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_favorites');
    }
};
