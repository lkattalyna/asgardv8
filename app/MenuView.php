<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuView extends Model
{
    protected $table = "menu_view";
    protected $primaryKey = "id_menu";
    public $incrementing = false;

    protected $fillable = [
        "id_menu",
        "inventario",
        "template_playbook",
        "grupo",
    ];
}
