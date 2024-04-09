<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cpu_marcas extends Model
{
    //
    protected $fillable = ['nombre'];

    public function modelos(){
        return $this->hasMany(cpu_modelos::class, 'id_cpu_marca', 'id');
    }
}
