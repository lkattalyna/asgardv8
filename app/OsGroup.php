<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OsGroup extends Model
{
    protected $fillable = ['name','flag', 'show_to'];
}
