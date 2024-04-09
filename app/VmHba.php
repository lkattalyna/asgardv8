<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VmHba extends Model
{
    public function vmHost(){
        return $this->BelongsTo(VmHost::class,'id_vmhost','id');
    }
}
