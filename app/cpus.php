<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cpus extends Model
{
    //
    protected $guarded = [];

    public function modelo(){
        return $this->belongsTo(cpu_modelos::class, 'id_cpu_modelo', 'id');
    }
}
