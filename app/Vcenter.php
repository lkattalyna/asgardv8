<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vcenter extends Model
{
    //Se instancia la conexion de la base de datos y la tabla objetivo
    protected $connection = 'central';
    protected $table = 'vcenter';
    protected $primaryKey = 'vcenterID';

    protected $fillable = [
        'fk_segmentID', 'fk_loginAccountID', 'vcenterIp','vcenterAlias','vcenterStatus'
    ];

}
