<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_hosts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vm_id',100);
            $table->string('name',200);
            $table->string('power_state',30);
            $table->string('memory',30);
            $table->string('cpu',30);
            $table->string('cluster',200);
            $table->string('datacenter',200);
            $table->string('vcenter',100);
            $table->string('customer_name',120)->nullable();
            $table->boolean('hot_add_memory')->default(0);
            $table->boolean('hot_add_cpu')->default(0);
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
        Schema::dropIfExists('virtual_hosts');
    }
}
