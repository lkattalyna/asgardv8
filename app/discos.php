<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class discos extends Model
{
    //
    protected $guarded = [];

    public function marca(){
        return $this->belongsTo(disco_marcas::class, 'id_disco_marca', 'id');
    }
}
