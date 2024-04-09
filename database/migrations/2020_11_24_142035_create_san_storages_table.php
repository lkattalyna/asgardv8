<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('san_storages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',40);
            $table->string('trademark',20);
            $table->string('model',35);
            $table->string('type',20)->nullable()->default('N/A');
            $table->string('serial',40);
            $table->string('id_naa',20)->nullable()->default('N/A');
            $table->string('location',30);
            $table->string('code',20);
            $table->string('cache',10);
            $table->tinyInteger('processor');
            $table->string('main_ip',15);
            $table->string('others_ip',64)->nullable()->default('N/A');
            $table->date('support_date')->nullable();
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
        Schema::dropIfExists('san_storages');
    }
}
