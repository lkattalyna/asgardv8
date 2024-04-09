<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SanNas extends Model
{
    protected $guarded = [];

    public function owner(){
        return $this->BelongsTo(User::class,'owner_id','id');
    }
}
