<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VmHost extends Model
{
    protected $guarded = [];
    protected $table = 'central.VmHost';

    public function vmHbas(){
        return $this->hasMany(VmHba::class,'id_vmhost','id');
    }
    public function vmNics(){
        return $this->hasMany(VmNic::class,'id_vmhost','id');
    }
}
