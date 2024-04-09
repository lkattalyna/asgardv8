<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vmhostr extends Model
{
    protected $connection = 'central';
    protected $table = 'vmhost';
    protected $primaryKey = 'vmhostID';

    protected $fillable = ['vmhostName'];
}
