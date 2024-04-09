<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegImprovementHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_improvement_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('improvement_id');
            $table->unsignedBigInteger('user_id');
            $table->string('comment',200)->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->string('evidence',150)->nullable()->default('N/A');
            $table->string('type',20)->nullable();
            $table->timestamps();
            $table->foreign('improvement_id')->references('id')->on('reg_improvements')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reg_improvement_histories');
    }
}
