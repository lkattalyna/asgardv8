<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vm extends Model
{
    //Se instancia la conexion de la base de datos y la tabla objetivo
    //protected $connection = 'central';
    const CREATED_AT = 'vmCreatedAt';
    const UPDATED_AT = 'vmUpdatedAt';
    protected $table = 'central.vm';
    protected $primaryKey = 'vmID';

    protected $fillable = [
        'vmName',
        'vmPowerState',
        'vmMemoryGB',
        'vmCpuCount',
        'fk_vmhostID',
    ];
}
