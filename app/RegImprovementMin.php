<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegImprovementMin extends Model
{
    protected $guarded = [];

    public function owner(){
        return $this->BelongsTo(User::class,'owner_id','id');
    }
    public function serviceSegment(){
        return $this->BelongsTo(RegServiceSegment::class,'segment_id','id');
    }
    public function serviceLayer(){
        return $this->BelongsTo(RegServiceLayer::class,'layer_id','id');
    }
}
