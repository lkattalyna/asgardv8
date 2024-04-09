<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegImprovement extends Model
{
    protected $guarded = [];

    public function histories(){
        return $this->hasMany(RegImprovementHistory::class,'improvement_id','id');
    }
    public function documentation(){
        return $this->hasOne(Documentation::class,'improvement_id','id');
    }
    public function asgView(){
        return $this->hasOne(DevRequest::class,'improvement_id','id');
    }
    public function owner(){
        return $this->BelongsTo(User::class,'owner_id','id');
    }
    public function customerLevel(){
        return $this->BelongsTo(RegCustomerLevel::class,'customer_level_id','id');
    }
    public function customerLevelPost(){
        return $this->BelongsTo(RegCustomerLevel::class,'customer_level_post_id','id');
    }
    public function approver(){
        return $this->BelongsTo(User::class,'approver_id','id');
    }
    public function serviceSegment(){
        return $this->BelongsTo(RegServiceSegment::class,'segment_id','id');
    }
    public function serviceLayer(){
        return $this->BelongsTo(RegServiceLayer::class,'layer_id','id');
    }
}
