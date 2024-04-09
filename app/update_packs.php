<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class update_packs extends Model
{
    //
    protected $guarded = [];

    public function marca()
    {
        return $this->belongsTo(server_marcas::class, 'id_marca', 'id');
    }
    public function modelo()
    {
        return $this->belongsTo(server_modelos::class, 'id_modelo', 'id');
    }
}
