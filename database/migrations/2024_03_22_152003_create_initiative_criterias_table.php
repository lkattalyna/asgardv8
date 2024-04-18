<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitiativeCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initiative_criterias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('initiative_id')->unsigned();
            $table->string('criterio');
            $table->timestamps();
            $table->foreign('initiative_id')->references('id')->on('initiatives')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('initiative_criterias');
    }
}
