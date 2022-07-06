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
        Schema::create('package_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
        
            $table->integer('number_of_people') ->nullable()    ;
            
            $table->timestamps();
            
            // $table->integer('img_qr')           ->nullable()    ;

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')   ->references('id')->on('users')  ->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_booking');
    }
};
