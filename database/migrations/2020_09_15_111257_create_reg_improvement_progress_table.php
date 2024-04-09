<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegImprovementProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_improvement_progress', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('ci')->nullable();
            $table->unsignedTinyInteger('dev')->nullable();
            $table->unsignedTinyInteger('int')->nullable();
            $table->unsignedTinyInteger('test')->nullable();
            $table->unsignedTinyInteger('tracing')->nullable();
            $table->unsignedTinyInteger('register')->nullable();
            $table->unsignedTinyInteger('documentation')->nullable();
            $table->unsignedTinyInteger('asgard')->nullable();
            $table->unsignedTinyInteger('pending')->nullable();
            $table->unsignedTinyInteger('total')->nullable();
            $table->unsignedBigInteger('improvement_id');
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
        Schema::dropIfExists('reg_improvement_progress');
    }
}
