<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegImprovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_improvements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('asgard_view');
            $table->string('description', 200);
            $table->string('deliverable', 80)->nullable();
            $table->string('scope', 200);
            $table->string('objetive', 200);
            $table->string('task_type', 20);
            $table->string('aut_type', 15);
            $table->smallInteger('dependence')->default(0);
            $table->string('frequency', 15);
            $table->unsignedSmallInteger('frequency_times')->default(0);;
            $table->unsignedSmallInteger('ci_goal');
            $table->unsignedSmallInteger('ci_progress')->default(0);
            $table->unsignedSmallInteger('minutes_before')->default(0);
            $table->unsignedSmallInteger('minutes_after')->default(0);
            $table->unsignedSmallInteger('minutes_total')->default(0);
            $table->string('playbook_name',50)->nullable();
            $table->unsignedTinyInteger('approval_status')->default(0);
            $table->boolean('test_approval_status')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('close_date')->nullable();
            $table->unsignedTinyInteger('doc_progress')->default(0);
            $table->unsignedTinyInteger('view_progress')->default(0);
            $table->unsignedTinyInteger('test_progress')->default(0);
            $table->unsignedTinyInteger('int_progress')->default(0);
            $table->unsignedTinyInteger('dev_progress')->default(0);
            $table->unsignedTinyInteger('total_progress')->default(0);
            $table->unsignedBigInteger('approver_id')->default(0);
            $table->unsignedBigInteger('test_approver_id')->default(0);
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('customer_level_id');
            $table->unsignedBigInteger('customer_level_post_id');
            $table->unsignedBigInteger('segment_id');
            $table->unsignedBigInteger('layer_id');
            $table->timestamps();
            $table->foreign('customer_level_id')->references('id')->on('reg_customer_levels');
            $table->foreign('customer_level_post_id')->references('id')->on('reg_customer_levels');
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
        Schema::dropIfExists('reg_improvements');
    }
}
