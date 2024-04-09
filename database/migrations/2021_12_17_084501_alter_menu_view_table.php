<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMenuViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement('ALTER TABLE menu_view MODIFY COLUMN `template_playbook` VARCHAR(100) ;');
        DB::statement('ALTER TABLE menu_view MODIFY COLUMN `inventario` VARCHAR(100) ;');
        DB::statement('ALTER TABLE menu_view MODIFY COLUMN `grupo` VARCHAR(100) ;');
        
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
