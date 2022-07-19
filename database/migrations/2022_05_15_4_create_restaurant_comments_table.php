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
        Schema::create('restaurant_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comment');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('restaurant_id')->unsigned()->index();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('restaurant_comments');
    }
};
