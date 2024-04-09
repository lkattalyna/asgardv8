<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bios_fw_old',30)->nullable();
            $table->string('bios_fw_new',30)->nullable();
            $table->string('ilo_fw_old',30)->nullable();
            $table->string('ilo_fw_new',30)->nullable();
            $table->string('controladora_fw_old',30)->nullable();
            $table->string('controladora_fw_new',30)->nullable();
            $table->string('pm_fw_old',30)->nullable();
            $table->string('pm_fw_new',30)->nullable();
            $table->string('nic_fw_old',30)->nullable();
            $table->string('nic_fw_new',30)->nullable();
            $table->string('hba_fw_old',30)->nullable();
            $table->string('hba_fw_new',30)->nullable();
            $table->string('oa_fw_old',30)->nullable();
            $table->string('oa_fw_new',30)->nullable();
            $table->string('vc_san_fw_old',30)->nullable();
            $table->string('vc_san_fw_new',30)->nullable();
            $table->string('vc_lan_fw_old',30)->nullable();
            $table->string('vc_lan_fw_new',30)->nullable();
            $table->string('cambio', 255)->nullable()->default('NO APLICA');
            $table->unsignedBigInteger('id_server');
            $table->unsignedBigInteger('id_update_pack');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_server')->references('id')->on('servers');
            $table->foreign('id_update_pack')->references('id')->on('update_packs');
            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('update_logs');
    }
}
