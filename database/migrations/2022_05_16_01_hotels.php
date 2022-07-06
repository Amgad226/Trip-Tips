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
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('rate')          ;
            $table->string('location')       ;
            $table->integer('Payment')       ;
            $table->string('support_email')  ;
            $table->string('img_title_deed')     ;
            
            // $table->integer('category_id')   ->nullable();
            // $table->foreign('category_id') ->references('id')->on('catigories')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('hotels');
    }
};
