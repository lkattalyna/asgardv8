<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $guarded = [];
    protected $table = "history";
	protected $fillable = [
        'id_asgard', 'id_caso', 'valor_anterior','valor_nuevo','usuario', 'id_automatizacion', 'id_playbook',

    ];
}
