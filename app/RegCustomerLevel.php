<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegCustomerLevel extends Model
{
    protected $fillable = ['name'];

    public function regImprovements()
    {
        return $this->hasMany(RegImprovement::class,'customer_level_id','id');
    }
    public function regPostImprovements()
    {
        return $this->hasMany(RegImprovement::class,'customer_level_post_id','id');
    }
}
