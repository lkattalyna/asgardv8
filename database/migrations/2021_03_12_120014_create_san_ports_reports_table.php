<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanPortsReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('san_ports_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_switch');
            $table->string('id_report',6);
            $table->string('port',5);
            $table->string('frames_tx',15)->nullable();
            $table->string('frames_rx',15)->nullable();
            $table->string('enc_in',15)->nullable();
            $table->string('crc_err',15)->nullable();
            $table->string('crc_g_eof',15)->nullable();
            $table->string('too_shrt',15)->nullable();
            $table->string('too_long',15)->nullable();
            $table->string('bad_eof',15)->nullable();
            $table->string('enc_out',15)->nullable();
            $table->string('disc_c3',15)->nullable();
            $table->string('link_fail',15)->nullable();
            $table->string('loss_sync',15)->nullable();
            $table->string('loss_sig',15)->nullable();
            $table->string('frjt',15)->nullable();
            $table->string('fbsy',15)->nullable();
            $table->string('c3_timeout_tx',15)->nullable();
            $table->string('c3_timeout_rx',15)->nullable();
            $table->string('pcs_err',15)->nullable();
            $table->string('uncor_err',15)->nullable();
            $table->foreign('id_switch')->references('id')->on('san_switches');
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
        Schema::dropIfExists('san_ports_reports');
    }
}
