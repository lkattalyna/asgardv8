<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('san_servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',40);
            $table->string('serial',20)->nullable()->default('N/A');
            $table->string('os',40);
            $table->string('main_ip',15);
            $table->string('others_ip',64)->nullable()->default('N/A');
            $table->string('code',30);
            $table->string('memory',10)->nullable()->default('N/A');
            $table->string('location',50);
            $table->string('storage',50)->nullable()->default('N/A');
            $table->string('info',100)->nullable()->default('N/A');
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
        Schema::dropIfExists('san_servers');
    }
}
