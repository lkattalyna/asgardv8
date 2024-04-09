<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('group',120)->nullable();
            $table->string('email',150)->nullable();
            $table->string('password')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('developer')->default(0);
            $table->text('session_id')->nullable()->comment('Almacena el id de la sesión del usuario');
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip',20)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
