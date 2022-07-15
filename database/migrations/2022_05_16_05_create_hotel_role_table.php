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
        Schema::create('hotel_role', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')           ->unsigned()->index();
            $table->integer('hotel_id')          ->unsigned()->index();
            $table->integer('role_facilities_id')->unsigned()->index();

            $table->string('hotel_name')->nullable();
            $table->string('role_facilities_name')->nullable();

            $table->foreign('role_facilities_id')->references('id')->on('roles_facilities') ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')           ->references('id')->on('users')            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hotel_id')          ->references('id')->on('hotels')            ->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('hotel_role');
    }
};
