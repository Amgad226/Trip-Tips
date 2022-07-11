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
        Schema::create('package_airplanes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airplane_id')->unsigned()->index();
            $table->integer('class_airplane_id')->unsigned()->index();

            $table->integer('package_id')->unsigned()->index();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
            

                       
            
            $table->foreign('class_airplane_id')->references('id')->on('airplane_classes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('package_airplanes');
    }
};
