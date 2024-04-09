<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nic_referencias extends Model
{
    //
    protected $fillable = ['nombre'];

    public function servers(){
        return $this->hasMany(servers::class, 'id_servidor', 'id');
    }
}
