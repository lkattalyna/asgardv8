<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmClusterCapacitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_cluster_capacities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vcenter',40);
            $table->string('cluster_name',120);
            $table->unsignedTinyInteger('host_count');
            $table->string('type_cluster',20)->nullable();
            $table->unsignedSmallInteger('vm_count');
            $table->float('cpu_total_ghz',7,2);
            $table->float('cpu_total_ha',7,2);
            $table->float('cpu_success',7,2);
            $table->string('cpu_default_field',40)->nullable();
            $table->float('cpu_free',7,2);
            $table->float('cpu_free_percent',7,2);
            $table->string('cpu_ha_sn',5);
            $table->float('cpu_used',7,2);
            $table->float('cpu_used_percent',7,2);
            $table->string('cpu_status',15);
            $table->float('memory_total_gb',7,2);
            $table->float('memory_total_ha',7,2);
            $table->float('memory_success',7,2);
            $table->string('memory_default_field',40)->nullable();
            $table->float('memory_free',7,2);
            $table->float('memory_free_percent',7,2);
            $table->string('memory_ha_sn',5);
            $table->float('memory_used',7,2);
            $table->float('memory_used_percent',7,2);
            $table->string('memory_status',15);
            $table->string('cluster_availability',15)->nullable();
            $table->string('cluster_status',40)->nullable();
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
        Schema::dropIfExists('vm_cluster_capacities');
    }
}
