<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegServiceSegment extends Model
{
    protected $guarded = [];

    public function coordinator(){
        return $this->BelongsTo(User::class,'coordinator_id','id');
    }
    public function serviceLayers(){
        return $this->hasMany(RegServiceLayer::class,'segment_id','id');
    }
}
