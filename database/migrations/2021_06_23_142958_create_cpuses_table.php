<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_cpu_modelo');
            $table->unsignedBigInteger('id_servidor');
            $table->integer('cantidad');
            $table->string('observacion')->default('N/A');
            $table->foreign('id_cpu_modelo')->references('id')->on('cpu_modelos');
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
        Schema::dropIfExists('cpuses');
    }
}
