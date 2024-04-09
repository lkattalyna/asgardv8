<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_servidor');
            $table->unsignedBigInteger('id_tipo_memoria');
            $table->integer('cantidad');
            $table->string('capacidad',255)->nullable()->default('NO APLICA');
            $table->foreign('id_tipo_memoria')->references('id')->on('tipo_memorias');
            $table->foreign('id_servidor')->references('id')->on('servers');
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
        Schema::dropIfExists('memorias');
    }
}
