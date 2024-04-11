<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Add new_user_id column
            $table->unsignedBigInteger('new_user_id')->nullable()->after('u_id');
            $table->foreign('new_user_id')->references('u_id')->on('users')->onDelete('cascade');

            // Add app_id column
            $table->unsignedBigInteger('app_id')->nullable()->after('new_user_id');
            $table->foreign('app_id')->references('app_id')->on('approvals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['new_user_id']);
            $table->dropForeign(['app_id']);

            // Drop columns
            $table->dropColumn('new_user_id');
            $table->dropColumn('app_id');
        });
    }
}
