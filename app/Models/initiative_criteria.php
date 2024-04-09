<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class initiative_criteria extends Model
{
    use HasFactory;
    protected $fillable =
        [
        'initiative_id',
        'criterio',
        'created_at',
        'updated_at',
        ];
}
