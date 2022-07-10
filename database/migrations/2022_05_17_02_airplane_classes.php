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
        Schema::create('airplane_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_name');
            $table->integer('money');

            $table->integer('airplane_id')->unsigned()->index();
            $table->foreign('airplane_id')->references('id')->on('airplanes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('classes_in_airplane');
    }
};
