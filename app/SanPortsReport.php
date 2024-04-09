<?php

namespace App;

use App\SanSwitch;
use Illuminate\Database\Eloquent\Model;

class SanPortsReport extends Model
{
    public function getSwitch(){
        return $this->BelongsTo(SanSwitch::class,'id_switch','id');
    }
}
