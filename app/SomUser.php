<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SomUser extends Model
{
    protected $connection = 'reports';
    protected $table = 'log_user_avaya';
}
