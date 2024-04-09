<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SanPort extends Model
{
    protected $guarded = [];

    public function getSwitch(){
        return $this->BelongsTo(SanSwitch::class,'id_switch','id');
    }
}
