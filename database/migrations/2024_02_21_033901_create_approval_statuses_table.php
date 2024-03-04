<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Seed the default approval statuses
        $this->seedApprovalStatuses();
    }

    public function down()
    {
        Schema::dropIfExists('approval_statuses');
    }

    private function seedApprovalStatuses()
    {
        $statuses = [
            ['name' => 'Approved'],
            ['name' => 'Pending'],
            ['name' => 'Denied'],
        ];

        \DB::table('approval_statuses')->insert($statuses);
    }
}
