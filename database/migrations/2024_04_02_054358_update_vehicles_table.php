<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('code_number');
            $table->dropColumn('model_number');
            $table->dropColumn('serial_number');
            $table->dropColumn('vehicle_type');
            
            $table->unsignedBigInteger('status_id')->nullable()->after('vehicle_type');
            $table->foreign('status_id')->references('id')->on('vehicle_status')->onDelete('cascade');

            $table->unsignedBigInteger('type_id')->nullable()->after('status_id');
            $table->foreign('type_id')->references('vtype_id')->on('vehicle_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
           // Drop foreign keys
           $table->dropForeign(['status_id']);
           $table->dropForeign(['type_id']);
           // Drop columns
           $table->dropColumn('status_id');
           $table->dropColumn('type_id');
        });
    }
}
