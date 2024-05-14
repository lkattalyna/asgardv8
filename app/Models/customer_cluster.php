<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_cluster extends Model
{
    //use HasFactory;

    protected $table = 'central.customer_cluster';

    protected $primaryKey = 'customerclusterID';
    
    
    protected $fillable = 
    [
        'fk_customerID',
        'fk_clusterID',
        
    ];
}
