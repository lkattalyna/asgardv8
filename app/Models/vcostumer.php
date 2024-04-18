<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vcenter extends Model
{
    //Se instancia la conexion de la base de datos y la tabla objetivo
    protected $fillable = [
        'initiative_name',
        'segment_id',
        'service_layer_id',
        'how',
        'want',
    ];

}
