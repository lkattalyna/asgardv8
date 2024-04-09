<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmDatastoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_datastorages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100);
            $table->string('parent',20);
            $table->string('st_type',20);
            $table->string('naa',50);
            $table->string('capacity',20);
            $table->string('policy',20)->nullable();
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
        Schema::dropIfExists('vm_datastorages');
    }
}
