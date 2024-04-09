<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class server_estados extends Model
{
    //
    protected $fillable = ['nombre'];

    public function servidores(){
        return $this->HasMany(servers::class,'id_estado','id');
    }
}
