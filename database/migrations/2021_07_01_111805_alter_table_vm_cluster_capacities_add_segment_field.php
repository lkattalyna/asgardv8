<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableVmClusterCapacitiesAddSegmentField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vm_cluster_capacities', function (Blueprint $table) {
            //
            $table->string('segment',20)->nullable()->default('EN');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vm_cluster_capacities', function (Blueprint $table) {
            //
        });
    }
}
