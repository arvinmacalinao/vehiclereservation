<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id('pass_id');
            $table->unsignedBigInteger('r_id')->nullable();
            $table->foreign('r_id')->references('r_id')->on('reservations')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('u_id')->nullable();
            $table->foreign('u_id')->references('u_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('tagged')->default(0);
            $table->tinyInteger('approved')->default(0);
            $table->tinyInteger('disapproved')->default(0);
            $table->timestamps();
        });;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passengers');
    }
}
