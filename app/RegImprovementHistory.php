<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegImprovementHistory extends Model
{
    protected $guarded = [];

    public function improvement(){
        return $this->BelongsTo(RegImprovement::class,'improvement_id','id');
    }
    public function user(){
        return $this->BelongsTo(User::class,'user_id','id');
    }
}
