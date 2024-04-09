<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevRequest extends Model
{
    protected $guarded = [];

    public function fields(){
        return $this->hasMany(DevRequestField::class,'request_id','id');
    }
    public function customer(){
        return $this->BelongsTo(User::class,'client_id','id');
    }
    public function state(){
        return $this->BelongsTo(DevState::class,'state_id','id');
    }
    public function task(){
        return $this->BelongsTo(DevTask::class,'task_id','id');
    }
    public function owner(){
        return $this->BelongsTo(User::class,'owner_id','id');
    }
    public function histories(){
        return $this->hasMany(DevRequestHistory::class,'request_id','id');
    }
    public function improvement(){
        return $this->BelongsTo(RegImprovement::class,'improvement_id','id');
    }

}
