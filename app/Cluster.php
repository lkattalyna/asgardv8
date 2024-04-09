<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    //Se instancia la conexion de la base de datos y la tabla objetivo
    protected $connection = 'central';
    protected $table = 'cluster';
    protected $primaryKey = 'clusterID';

    protected $fillable = [        
        'vcenterAlias'
    ];
}
