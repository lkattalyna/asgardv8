<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwxTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awx_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_template');
            $table->string('name',120);
            $table->string('description',150)->nullable();
            $table->unsignedBigInteger('id_inventory')->nullable();
            $table->string('playbook',150)->nullable();
            $table->string('limit',100)->nullable();
            $table->boolean('ask_variables_on_launch');
            $table->boolean('ask_limit_on_launch');
            $table->boolean('job_schedule')->nullable();
            $table->boolean('survey_enabled')->nullable();
            $table->boolean('allow_simultaneous')->nullable();
            $table->dateTime('ansible_created_at')->nullable();
            $table->dateTime('ansible_updated_at')->nullable();
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
        Schema::dropIfExists('awx_templates');
    }
}
