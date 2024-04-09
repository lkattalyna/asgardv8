<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerModelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_modelos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo',20);
            $table->string('modelo',60);
            $table->string('generacion',10);
            $table->unsignedBigInteger('id_server_marca');
            $table->foreign('id_server_marca')->references('id')->on('server_marcas');
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
        Schema::dropIfExists('server_modelos');
    }
}
