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
        Schema::create('airplane_favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_airplane_fav');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('airplane_id')->unsigned()->index();
            $table->foreign('airplane_id')->references('id')->on('airplanes')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('airplane_favorites');
    }
};
