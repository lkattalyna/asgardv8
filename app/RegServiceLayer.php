<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegServiceLayer extends Model
{
    protected $fillable = ['name','model','segment_id','leader_id','coordinator_id'];

    public function leader(){
        return $this->BelongsTo(User::class,'leader_id','id');
    }
    public function coordinator(){
        return $this->BelongsTo(User::class,'coordinator_id','id');
    }
    public function serviceSegment(){
        return $this->BelongsTo(RegServiceSegment::class,'segment_id','id');
    }
}
