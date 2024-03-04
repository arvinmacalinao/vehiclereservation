<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('r_id');
            $table->unsignedBigInteger('u_id')->nullable();
            $table->foreign('u_id')->references('u_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('v_id')->nullable();
            $table->foreign('v_id')->references('v_id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->string('driver_name')->nullable();
            $table->text('purpose');
            $table->text('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('time')->nullable();
            $table->string('remarks')->nullable();
            $table->string('others')->nullable();
            $table->string('requested_by')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('recommending')->default(0);
            $table->tinyInteger('approval')->default(0);
            $table->tinyInteger('status_by')->unsigned()->nullable();
            $table->tinyInteger('recommending_by')->unsigned()->nullable();
            $table->tinyInteger('approval_by')->unsigned()->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_printed')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('reservations');
    }
}
