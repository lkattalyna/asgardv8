<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cpu_modelos extends Model
{
    //
    protected $fillable = ['nombre','id_cpu_marca'];

    public function marca(){
        return $this->belongsTo(cpu_marcas::class, 'id_cpu_marca', 'id');
    }
    public function servers(){
        return $this->hasMany(servers::class, 'id_servidor', 'id');
    }
}
