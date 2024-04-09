<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hbas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_servidor');
            $table->integer('cantidad')->nullable()->default('0');
            $table->string('puertos', 255)->nullable()->default('NO APLICA');
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
        Schema::dropIfExists('hbas');
    }
}
