<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CredentialChange extends Model
{
    //Se instancia la conexion de la base de datos y la tabla objetivo

    protected $table = 'credential_change';

    protected $fillable = [
        "name"
    ];
}
