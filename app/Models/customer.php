<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'central.customer';
    const CREATED_AT = 'customerCreatedAt';
    const UPDATED_AT = 'customerUpdatedAt';

    protected $primaryKey = 'customerID';

    protected $fillable = [
        'customerID',
        'customerName',
        'customerNIT',
        'customerState',
        'customerCreatedAt',
        'customerUpdatedAt'
    ];
}

