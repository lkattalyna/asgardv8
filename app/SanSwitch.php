<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SanSwitch extends Model
{
    protected $guarded = [];

    public function owner(){
        return $this->BelongsTo(User::class,'owner_id','id');
    }
    public function ports(){
        return $this->hasMany(SanPort::class,'id_switch','id');
    }
}
