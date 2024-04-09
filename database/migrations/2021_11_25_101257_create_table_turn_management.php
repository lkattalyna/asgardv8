<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTurnManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turn_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->tinyInteger('turn');
            $table->tinyInteger('suspended_case')->nullable()->default('0');
            $table->string('suspended_name',100)->nullable();
            $table->string('suspended_reason',255)->nullable();
            $table->string('suspended_dates',100)->nullable();
            $table->tinyInteger('pending_case')->nullable()->default('0');
            $table->string('pending_name',100)->nullable();
            $table->string('pending_reason',255)->nullable();
            $table->string('observations',255)->nullable();
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
        Schema::dropIfExists('turn_management');
    }
}
