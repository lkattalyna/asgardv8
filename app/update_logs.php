<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class update_logs extends Model
{
    //
    protected $guarded = [];

    public function server()
    {
        return $this->belongsTo(servers::class, 'id_server', 'id');
    }
    public function updatePack()
    {
        return $this->belongsTo(update_packs::class, 'id_update_pack', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
