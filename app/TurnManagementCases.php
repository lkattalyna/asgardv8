<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurnManagementCases extends Model
{
    //Se instancia la conexion de la base de datos y la tabla objetivo

    protected $table = 'turn_cases';

    protected $fillable = [
        "name",
        "turn",
        "type",
        "case",
        "reason",
        "dates",
    ];
}
