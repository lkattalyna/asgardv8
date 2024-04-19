<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitiativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initiatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('initiative_name');
            $table->string('segment_name');
            $table->string('tower');
            $table->text('how'); 
            $table->text('want'); 
            $table->text('for'); 
            $table->string('task_type');
            $table->string('automation_type');
            $table->text('general_description');
            $table->string('attachments');
            $table->integer('execution_time_manual');
            $table->string('advantages');
            $table->integer('owner_id');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            // llave foranea tabla users
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            //$table->timestamps('created_at');
            //$table->timestamps('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('initiatives');
    }
}
