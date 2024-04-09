<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_disco_marca');
            $table->unsignedBigInteger('id_servidor');
            $table->integer('cantidad');
            $table->string('capacidad', 255)->nullable()->default('NO APLICA');
            $table->string('numeroParte', 255)->nullable()->default('NO APLICA');
            $table->foreign('id_disco_marca')->references('id')->on('disco_marcas');
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
        Schema::dropIfExists('discos');
    }
}
