<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_vcenter extends Model
{
    //use HasFactory;

    protected $table = 'central.customer_vcenter';

    protected $primaryKey = 'customervcenterID';
    
    
    protected $fillable = 
    [
        'fk_customerID',
        'fk_vcenterID',
        
    ];
}
