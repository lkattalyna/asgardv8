<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTurnCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turn_cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->tinyInteger('turn');			
            $table->string('type',20)->nullable();
			$table->string('case', 255)->nullable();
            $table->string('reason',255)->nullable();
            $table->string('dates',100)->nullable();
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
        Schema::dropIfExists('turn_cases');
    }
}
