<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Add new 'vtype_id' column as integer
            $table->unsignedBigInteger('vtype_id')->after('time')->nullable();
            $table->foreign('vtype_id')->references('vtype_id')->on('vehicle_types');

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
            $table->dropForeign(['vtype_id']);
            $table->dropColumn('vtype_id');
        });
    }
}
