<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VmHnasReport extends Model
{
    public function users(){
        return $this->hasMany(VmHnasUsersReport::class,'id_report','id');
    }
    public function usersDisabled(){
        return $this->hasMany(VmHnasUsersDisabledReport::class,'id_report','id');
    }
}
