<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nics extends Model
{
    //
    protected $guarded = [];

    public function referencia(){
        return $this->belongsTo(nic_referencias::class, 'id_nic_ref', 'id');
    }
}
