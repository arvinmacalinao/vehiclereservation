<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id('app_id');
            $table->unsignedBigInteger('r_id')->nullable();
            $table->foreign('r_id')->references('r_id')->on('reservations')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('g_id')->nullable();
            $table->foreign('g_id')->references('g_id')->on('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('u_id')->nullable();
            $table->foreign('u_id')->references('u_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')
            ->references('id')
            ->on('approval_statuses') // Corrected table name
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('approvals');
    }
}
