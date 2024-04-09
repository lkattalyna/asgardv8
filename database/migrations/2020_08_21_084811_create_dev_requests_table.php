<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('template_id')->nullable();
            $table->unsignedSmallInteger('inventory_id')->nullable();
            $table->string('description',200)->nullable();
            $table->string('comment',200)->nullable();
            $table->string('title',100);
            $table->string('title_menu',30);
            $table->tinyInteger('success_id')->default(0);
            $table->tinyInteger('error_id')->default(0);
            $table->integer('total_time')->nullable();
            $table->boolean('read_terms');
            $table->date('expiration_date')->nullable();
            $table->dateTime('solved_at')->nullable();
            $table->unsignedBigInteger('improvement_id')->default(0);
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedInteger('owner_id');
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('dev_states');
            $table->foreign('task_id')->references('id')->on('dev_tasks');
            $table->foreign('client_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dev_requests');
    }
}
