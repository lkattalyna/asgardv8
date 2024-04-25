<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
     //Se instancia la conexion de la base de datos y la tabla objetivo
    // protected $connection = 'central';
     protected $table = 'central.segment';
     protected $primaryKey = 'segmentID';
 
     protected $fillable = [
         'segmentName', 'segmentStatus'
     ];
}