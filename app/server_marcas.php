<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class server_marcas extends Model
{
    //Cardinalidad de la tabla con los modelos
    protected $fillable = ['nombre'];

    public function modelos() {
        return $this->hasMany(server_modelos::class,'id_server_modelo','id');
    }
}
