<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReservations2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Drop the existing driver_name column
            // $table->dropColumn('driver_name');
            
            // Add the driver_id column and make it a foreign key
            $table->unsignedInteger('driver_id')->nullable()->after('v_id');
            $table->foreign('driver_id')->references('u_id')->on('users')->onDelete('set null');
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
