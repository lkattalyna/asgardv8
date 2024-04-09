<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VmNic extends Model
{
    public function vmHost(){
        return $this->BelongsTo(VmHost::class,'id_vmhost','id');
    }
}
