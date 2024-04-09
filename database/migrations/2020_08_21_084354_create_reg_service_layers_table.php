<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegServiceLayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_service_layers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('model',5);
            $table->unsignedBigInteger('segment_id');
            $table->unsignedBigInteger('leader_id')->nullable()->default(0);
            $table->unsignedBigInteger('coordinator_id')->nullable()->default(0);
            $table->timestamps();
            $table->foreign('segment_id')->references('id')->on('reg_service_segments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reg_service_layers');
    }
}
