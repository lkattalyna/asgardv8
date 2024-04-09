<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanSwitchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('san_switches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fabric',25);
            $table->Integer('domain');
            $table->string('sw',50);
            $table->string('ip',15);
            $table->string('serial',25);
            $table->string('maker',20)->nullable()->default('No Registra');
            $table->string('model',20)->nullable()->default('No Registra');
            $table->date('support_date')->nullable();
            $table->string('mac',30)->nullable();
            $table->string('uptime',40)->nullable();
            $table->string('code',20)->nullable();
            $table->unsignedBigInteger('owner_id');
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
        Schema::dropIfExists('san_switches');
    }
}
