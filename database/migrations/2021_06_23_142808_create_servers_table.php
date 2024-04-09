<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_servicio',255);
            $table->string('serie',255);
            $table->string('site',30);
            $table->string('rack',30);
            $table->string('unidad_inferior',255)->default('NO APLICA');
            $table->string('unidad_superior',255)->default('NO APLICA');
            $table->string('bahia',255)->default('NO APLICA');
            $table->string('estado',10);
            $table->string('servicio_macro',10);
            $table->string('tiene_soporte',15)->default('NO APLICA');
            $table->string('tipo_soporte',255)->default('NO APLICA');
            $table->date('soporte')->nullable();
            $table->date('eol_date')->nullable();
            $table->date('eos_date')->nullable();
            $table->string('unidad_dvd',255)->default('NO APLICA');
            $table->string('fuentes',255)->default('NO APLICA');
            $table->string('bios_firmware',50)->default('NO APLICA');
            $table->string('nic_firmware',50)->default('NO APLICA');
            $table->string('ilo_firmware',50)->default('NO APLICA');
            $table->string('controladora_firmware',50)->default('NO APLICA');
            $table->string('power_management_firmware',50)->default('NO APLICA');
            $table->string('hba_firmware',50)->default('NO APLICA');
            $table->string('oa_firmware',50)->default('NO APLICA');
            $table->string('vc_san',50)->default('NO APLICA');
            $table->string('vc_lan',50)->default('NO APLICA');
            $table->string('ip',100)->default('NO APLICA');
            $table->string('observaciones', 1500)->nullable()->default('NO APLICA');
            $table->string('correos', 1500)->nullable()->default('NO APLICA');
            $table->string('fecha_Implementacion')->nullable()->default('NO APLICA');
            $table->string('fecha_Desistalacion')->nullable()->default('NO APLICA');
            $table->unsignedBigInteger('id_marca');
            $table->unsignedBigInteger('id_modelo');
            $table->unsignedBigInteger('id_propietario');
            $table->unsignedBigInteger('id_responsable');
            $table->unsignedBigInteger('id_so');
            $table->unsignedBigInteger('id_data_center');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_tipo_cliente');
            $table->unsignedBigInteger('id_tipo_hardware');
            $table->unsignedBigInteger('id_tipo_servicio');
            $table->unsignedBigInteger('id_tipo_rack');
            $table->unsignedBigInteger('id_controladora');
            $table->unsignedBigInteger('id_raid');
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_marca')->references('id')->on('server_marcas');
            $table->foreign('id_modelo')->references('id')->on('server_modelos');
            $table->foreign('id_propietario')->references('id')->on('propietarios');
            $table->foreign('id_responsable')->references('id')->on('responsables');
            $table->foreign('id_so')->references('id')->on('sistema_operativos');
            $table->foreign('id_data_center')->references('id')->on('data_centers');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_tipo_cliente')->references('id')->on('tipos_clientes');
            $table->foreign('id_tipo_hardware')->references('id')->on('tipos_hardwares');
            $table->foreign('id_tipo_servicio')->references('id')->on('tipos_servicios');
            $table->foreign('id_tipo_rack')->references('id')->on('tipos_racks');
            $table->foreign('id_controladora')->references('id')->on('controladoras');
            $table->foreign('id_raid')->references('id')->on('raids');
            $table->foreign('id_estado')->references('id')->on('server_estados');
            $table->softDeletes();
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
        Schema::dropIfExists('servers');
    }
}
