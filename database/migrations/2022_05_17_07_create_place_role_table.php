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
        Schema::create('place_role', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')           ->unsigned()->index();
            $table->integer('place_id')          ->unsigned()->index();
            $table->integer('role_facilities_id')->unsigned()->index();
            
            $table->foreign('role_facilities_id')->references('id')->on('roles_facilities') ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')           ->references('id')->on('users')            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('place_id')          ->references('id')->on('places')           ->onDelete('cascade')->onUpdate('cascade');
            
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_role');
    }
};
