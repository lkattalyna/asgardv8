<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmNicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_nics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_vmhost');
            $table->string('vmnic',30);
            $table->string('bus_info',50);
            $table->string('driver',20);
            $table->string('firmware',100);
            $table->string('version',20);
            $table->string('vid',10)->nullable();
            $table->string('did',10)->nullable();
            $table->string('svid',10)->nullable();
            $table->string('ssid',10)->nullable();
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
        Schema::dropIfExists('vm_nics');
    }
}
