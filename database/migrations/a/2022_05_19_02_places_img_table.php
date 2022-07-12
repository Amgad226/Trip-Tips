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
        Schema::create('places_img', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('places_id')->unsigned()->index();
        
            $table->string('img') ->nullable();
            
            $table->foreign('places_id')->references('id')->on('places')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('time')->useCurrent = true;
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
        Schema::dropIfExists('img_places');
    }
};
