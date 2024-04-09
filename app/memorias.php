<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class memorias extends Model
{
    //
    protected $guarded = [];

    public function tipo(){
        return $this->belongsTo(tipo_memorias::class, 'id_tipo_memoria', 'id');
    }
}
