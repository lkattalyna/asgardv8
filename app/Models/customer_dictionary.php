<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class customer_dictionary extends Model
{

    protected $table = 'central.customer_dictionary';

    protected $primaryKey = 'customerdictionaryID';
    
    
    protected $fillable = 
    [
        'fk_customerID',
        'value',
        'updated_at', 
        'created_at'
    ];
}
