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
        Schema::create('images_resturants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img');

            $table->integer('resturant_id')->unsigned()->index();
            $table->foreign('resturant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('images_resturants');
    }
};
