<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    protected $guarded = [];

    public function owner(){
        return $this->BelongsTo(User::class,'owner_id','id');
    }
    public function consumedService(){
        return $this->BelongsTo(RegConsumedService::class,'consumed_service_id','id');
    }
    public function regImprovement(){
        return $this->BelongsTo(RegImprovement::class,'improvement_id','id');
    }
    public function approver(){
        return $this->BelongsTo(User::class,'approver_id','id');
    }
}
