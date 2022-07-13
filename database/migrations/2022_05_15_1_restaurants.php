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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name');
            $table->integer('rate');
            $table->string('location');
            $table->integer('Payment');
            $table->string('support_email');
            $table->string('img_title_deed');
            $table->integer('price_booking');
            $table->string('description');
            $table->boolean('acceptable')->default(0);
            

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            
            // $table->integer('category_id') ->unsigned()->index();
            // $table->foreign('category_id') ->references('id')->on('catigories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('restaurant');
    }
};
