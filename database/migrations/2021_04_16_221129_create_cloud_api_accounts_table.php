<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudApiAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_api_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name',150);
            $table->string('address',150);
            $table->string('city',50);
            $table->string('country',50);
            $table->string('zip_code',10);
            $table->string('contact_name',150);
            $table->string('email',200);
            $table->string('phone',30);
            $table->string('id_account',30)->nullable();
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
        Schema::dropIfExists('cloud_api_accounts');
    }
}
