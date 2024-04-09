<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_hosts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200);
            $table->string('vcenter', 50);
            $table->string('cluster', 50);
            $table->string('vendor', 80)->nullable()->default('N/A');
            $table->string('service_code', 50)->nullable()->default('N/A');
            $table->string('ip', 15);
            $table->string('memory', 10);
            $table->string('cpu', 20);
            $table->string('total_disk', 20);
            $table->string('esxi_version', 20);
            $table->string('power_state', 20);
            $table->string('connection_state', 20);
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
        Schema::dropIfExists('vm_hosts');
    }
}
