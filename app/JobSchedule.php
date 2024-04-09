<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSchedule extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->BelongsTo(User::class,'user_id','id');
    }
}
