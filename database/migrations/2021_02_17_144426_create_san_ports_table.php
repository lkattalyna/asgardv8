<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanPortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('san_ports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slot',3)->default('N/A');
            $table->unsignedTinyInteger('port');
            $table->string('status',15)->default('LIBRE');
            $table->string('service',15)->default('SIN ASIGNAR');
            $table->string('name',100);
            $table->string('im',15)->nullable()->default('No Registra');
            $table->string('comment',300)->nullable()->default('N/A');
            $table->unsignedBigInteger('id_switch');
            $table->foreign('id_switch')->references('id')->on('san_switches');
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
        Schema::dropIfExists('san_ports');
    }
}
