<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevRequestFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_request_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('request_id');
            $table->unsignedTinyInteger('field_id');
            $table->string('field_type',30);
            $table->string('title',50);
            $table->string('name',20);
            $table->string('comment',150)->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('variable')->default(false);
            $table->timestamps();
            $table->foreign('request_id')->references('id')->on('dev_requests')->onDelete('cascade');
            $table->primary(['request_id','field_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dev_request_fields');
    }
}
