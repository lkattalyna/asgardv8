<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class customer extends Model
{
    protected $table = 'central.customer';
    const CREATED_AT = 'customerCreatedAt'; // Nombre de la columna de creación
    const UPDATED_AT = 'customerUpdatedAt';
    //Se instancia la conexion de la base de datos y la tabla objetivo
    protected $fillable = [
        'customerID',
        'customerName',
        'customerNIT',
        'customerState',
        'customerCreatedAt',
        'customerUpdatedAt'
    ];

}
