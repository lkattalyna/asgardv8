<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class initiative_states extends Model
{
    use HasFactory;
    protected $fillable =
        [
        'status_name',
        'statusID',
        'state',
        'created_at',
        'updated_at',
        ];
}
