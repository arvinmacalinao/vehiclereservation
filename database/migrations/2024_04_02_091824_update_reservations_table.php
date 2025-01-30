<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('recommending');
            $table->dropColumn('approval');
            $table->dropColumn('status_by');
            $table->dropColumn('recommending_by');
            $table->dropColumn('approval_by');
            $table->dropColumn('is_active');
            $table->dropColumn('is_read');
            $table->dropColumn('is_printed');
            $table->dropColumn('status');
            $table->unsignedBigInteger('driver_id')->nullable()->after('v_id');
            $table->foreign('driver_id')->references('u_id')->on('users')->onDelete('set null');
            $table->time('end_time')->nullable()->after('time');
            $table->unsignedBigInteger('status_id')->nullable()->after('requested_by');
            $table->foreign('status_id')->references('id')->on('reservation_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
        });
    }
}
