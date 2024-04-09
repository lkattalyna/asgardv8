<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('result',200);
            $table->string('components',200);
            $table->string('unrelated_layers',200)->default('Ninguna');
            $table->boolean('parameters_flag')->default(0);
            $table->string('parameters',100)->default('N/A');
            $table->boolean('tech_manual')->default(0);
            $table->boolean('approval_status')->default(0);
            $table->dateTime('approval_date')->nullable();
            $table->string('tech_manual_link',100)->default('N/A');
            $table->string('user_manual_link',100)->default('N/A');
            $table->unsignedBigInteger('consumed_service_id');
            $table->unsignedBigInteger('improvement_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('approver_id')->default(0);
            $table->timestamps();
            $table->foreign('consumed_service_id')->references('id')->on('reg_consumed_services');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('improvement_id')->references('id')->on('reg_improvements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentations');
    }
}
