<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurnManagement extends Model
{
    //Se instancia la conexion de la base de datos y la tabla objetivo

    protected $table = 'turn_management';

    protected $fillable = [
        "name",
        "turn",
        "suspended_case",
        "suspended_name",
        "suspended_reason",
        "suspended_dates",
        "pending_case",
        "pending_name",
        "pending_reason",
        "observations"
    ];
}
