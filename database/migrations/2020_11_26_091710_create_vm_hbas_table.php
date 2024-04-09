<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmHbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_hbas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('trademark',50);
            $table->string('reference',50);
            $table->string('wwnn',50);
            $table->string('wwpn',50);
            $table->string('firmware',50);
            $table->string('driver_name',80)->nullable()->default('No Registra');
            $table->string('driver_version',80)->nullable()->default('No Registra');
            $table->string('info',200);
            $table->string('vid',10)->nullable()->default('No Registra');
            $table->string('did',10)->nullable()->default('No Registra');
            $table->string('svid',10)->nullable()->default('No Registra');
            $table->string('ssid',10)->nullable()->default('No Registra');
            $table->unsignedBigInteger('id_vmhost');
            $table->timestamps();
            $table->foreign('id_vmhost')->references('id')->on('vm_hosts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vm_hbas');
    }
}
