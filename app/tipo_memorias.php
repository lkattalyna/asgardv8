<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_memorias extends Model
{
    //
    protected $fillable = ['nombre'];

    public function servers(){
        return $this->hasMany(servers::class, 'id_servidor', 'id');
    }
}
