<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('not_id');
            $table->string('not_message');
            $table->unsignedBigInteger('u_id')->nullable();
            $table->unsignedBigInteger('r_id')->nullable();
            $table->timestamp('read_at')->nullable();
            // Define foreign key constraints (if needed)
            $table->foreign('r_id')->references('r_id')->on('reservations');
            $table->foreign('u_id')->references('u_id')->on('users');
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
