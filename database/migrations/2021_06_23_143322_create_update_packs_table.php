<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_packs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',30);
            $table->string('bios_fw',30)->nullable()->default('NO APLICA');
            $table->string('ilo_fw',30)->nullable()->default('NO APLICA');
            $table->string('controladora_fw',30)->nullable()->default('NO APLICA');
            $table->string('power_management_fw',30)->nullable()->default('NO APLICA');
            $table->string('nic_fw',30)->nullable()->default('NO APLICA');
            $table->string('hba_fw',30)->nullable()->default('NO APLICA');
            $table->string('oa_fw',30)->nullable()->default('NO APLICA');
            $table->string('vc_san_fw',30)->nullable()->default('NO APLICA');
            $table->string('vc_lan_fw',30)->nullable()->default('NO APLICA');
            $table->boolean('vigente')->default(true);
            $table->unsignedBigInteger('id_marca');
            $table->unsignedBigInteger('id_modelo');
            $table->foreign('id_marca')->references('id')->on('server_marcas');
            $table->foreign('id_modelo')->references('id')->on('server_modelos');
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
        Schema::dropIfExists('update_packs');
    }
}
