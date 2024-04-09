<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinShareFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('win_share_folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('folder_name',280);
            $table->string('permission',20);
            $table->string('ad',100);
            $table->string('domain',50);
            $table->string('dc',100);
            $table->string('user',120);
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
        Schema::dropIfExists('win_share_folders');
    }
}
