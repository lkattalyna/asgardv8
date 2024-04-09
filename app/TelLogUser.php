<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelLogUser extends Model
{
    protected $connection = 'reports';
    protected $table = 'log_user_avaya';
}
