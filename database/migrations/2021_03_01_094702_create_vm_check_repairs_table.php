<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmCheckRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_check_repairs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',120)->nullable();
            $table->string('vcenter',50)->nullable();
            $table->string('id_asgard',20)->nullable();
            $table->string('item',30)->nullable();
            $table->string('status',15)->nullable();
            $table->string('description',100)->nullable();
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
        Schema::dropIfExists('vm_check_repairs');
    }
}
