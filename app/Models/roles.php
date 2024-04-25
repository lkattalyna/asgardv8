<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    protected $table = 'central.roles';
    protected $primaryKey = 'rolesID';


    // protected $primaryKey = 'customerID';

    protected $fillable = [
        'rolesAlias',
        'rolesStatus'
    ];
}