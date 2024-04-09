<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class disco_marcas extends Model
{
    //
    protected $fillable = ['nombre'];

    public function servers(){
        return $this->hasMany(servers::class, 'id_servidor', 'id');
    }
}
