<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_asgard',50);
            $table->string('id_caso',50);
            $table->string('valor_anterior',50);
            $table->string('valor_nuevo',50);
            $table->string('usuario',50);
            $table->bigInteger('id_automatizacion')->unsigned();
            $table->foreign('id_automatizacion')->references('id')->on('automatizaciones');
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
        Schema::dropIfExists('history');
    }
}
