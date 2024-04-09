<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('execution_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_job')->nullable()->default(0);
            $table->unsignedBigInteger('id_user')->nullable();
            $table->dateTime('d_ini_script')->nullable();
            $table->dateTime('d_end_script')->nullable();
            $table->smallInteger('status')->default(1);
            $table->string('user',120)->nullable();
            $table->string('user_group',120)->nullable();
            $table->string('playbook',120)->nullable();
            $table->string('elapsed',10)->nullable();
            $table->tinyInteger('form',1)->default(1);
            $table->tinyInteger('del_host',1)->default(0);
            $table->string('host_id_list',200)->nullable();
            $table->string('vars',1000)->nullable();
            $table->integer('id_inventory')->nullable();
            $table->integer('id_template')->nullable();
            $table->smallInteger('id_success')->default(0);
            $table->smallInteger('id_failed')->default(0);
            $table->string('result')->nullable();
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
        Schema::dropIfExists('execution_logs');
    }
}
