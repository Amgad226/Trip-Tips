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
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('price')->nullable();
            $table->integer('number_of_reservation')->default(0);
            $table->string('img');
            $table->string('description');
            $table->string('added_by');
            $table->integer('max_reservation');
            $table->integer('discount_percentage');
            $table->integer('number_of_day');
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->integer('tourist_supervisor_id')->unsigned()->index();
            $table->foreign('tourist_supervisor_id')->references('id')->on('tourist_supervisors')->onDelete('cascade')->onUpdate('cascade');
            
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id') ->references('id')->on('catigories_package')->onDelete('cascade')->onUpdate('cascade');
         
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
        Schema::dropIfExists('packages');
    }
};
