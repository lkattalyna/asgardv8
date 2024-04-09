<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalToolLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_tool_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_id',50)->nullable();
            $table->dateTime('d_ini_script')->nullable();
            $table->dateTime('d_end_script')->nullable();
            $table->string('elapsed',10)->nullable();
            $table->tinyInteger('status');
            $table->string('playbook',100)->nullable();
            $table->string('job_script',100)->nullable();
            $table->string('result',100)->nullable();
            $table->string('user',50)->nullable();
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
        Schema::dropIfExists('external_tool_logs');
    }
}
