<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NovedadesMaquinaBu extends Model
{
    protected $fillable= ['tipo','cliente','novedad','estado'];
}
