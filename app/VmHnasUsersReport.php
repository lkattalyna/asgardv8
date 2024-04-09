<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VmHnasUsersReport extends Model
{
    public function report(){
        return $this->BelongsTo(VmHnasReport::class,'report_id','id');
    }
}
