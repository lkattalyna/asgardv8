<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datacenter extends Model
{
     //Se instancia la conexion de la base de datos y la tabla objetivo
     protected $connection = 'central';
     protected $table = 'datacenter';
     protected $primaryKey = 'datacenterID';
 
     protected $fillable = [
         'datacenterID',
         'fk_vcenterID',
         'datacenterObjectID',
         'datacenterName',
         'datacenterCluster',
         'datacenterHost',
         'datacenterVm',
         'datacenterNetwork',
         'datacenterDatastore'
        ];
}
