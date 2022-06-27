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
        Schema::create('restaurant', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('category_id')   ->nullable();
            $table->string('name_en')        ->nullable();
            $table->string('name_ar')        ->nullable();
            $table->integer('rate')          ->nullable();
            $table->string('location')       ->nullable();
            $table->integer('Payment')       ->nullable();
            $table->integer('price_calss_A') ->nullable();
            $table->integer('price_calss_B') ->nullable();
            $table->string('support_email')  ->nullable();
            $table->boolean('active')->default(0);


          
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
        Schema::dropIfExists('restaurant');
    }
};
