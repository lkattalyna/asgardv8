<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevRequestHistory extends Model
{
    protected $guarded = [];

    public function devRequest(){
        return $this->BelongsTo(DevRequest::class,'request_id','id');
    }
    public function user(){
        return $this->BelongsTo(User::class,'user_id','id');
    }
    public function state(){
        return $this->BelongsTo(DevState::class,'state_id','id');
    }
}
