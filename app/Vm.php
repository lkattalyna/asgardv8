<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vm extends Model
{
    //Se instancia la conexion de la base de datos y la tabla objetivo
    protected $connection = 'central';
    protected $table = 'vm';
    protected $primaryKey = 'vmID';

    protected $fillable = ['vmName' ];
}
