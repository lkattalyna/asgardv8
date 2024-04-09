<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegImprovementMinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_improvement_mins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 200);
            $table->string('playbook_name',50)->nullable();
            $table->tinyInteger('end_date');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('segment_id');
            $table->unsignedBigInteger('layer_id');
            $table->unsignedBigInteger('improvement')->default(0);
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('segment_id')->references('id')->on('reg_service_segments');
            $table->foreign('layer_id')->references('id')->on('reg_service_layers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reg_improvement_mins');
    }
}
