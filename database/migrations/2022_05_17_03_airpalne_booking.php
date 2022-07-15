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
        Schema::create('airpalne_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airplane_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('airplane_class_id')->unsigned()->index();

            $table->string('from');
            $table->string('to');
            $table->text('note')->nullable();
            $table->integer('number_of_people');
            $table->integer('price');
            $table->timestamp('date');
            $table->boolean('by_packge')->nullable();
            $table->text('unique')   ;

            
            // $table->integer('img_qr')           ;
            // $table->integer('id_your_chois')    ->nullable()    ;

            $table->foreign('user_id')           ->references('id')->on('users')           ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('airplane_id')       ->references('id')->on('airplanes')       ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('airplane_class_id') ->references('id')->on('airplane_classes')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('airpalne_booking');
    }
};
