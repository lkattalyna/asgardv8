<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class server_modelos extends Model
{
    //Cardinalidad con la tabla de las marcas
    protected $guarded = [];

    public function marca() {
        return $this->belongsTo(server_marcas::class,'id_server_marca','id');
    }
}
