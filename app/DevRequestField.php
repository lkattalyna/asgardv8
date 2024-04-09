<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class DevRequestField extends Model
{
    protected $primaryKey = ['request_id', 'field_id'];
    public $incrementing = false;
    protected $guarded = [];
    protected function setKeysForSaveQuery($query)
    {
        foreach ($this->getKeyName() as $key) {
            // UPDATE: Added isset() per devflow's comment.
            if (isset($this->$key))
                $query->where($key, '=', $this->$key);
            else
                throw new Exception(__METHOD__ . 'Missing part of the primary key: ' . $key);
        }

        return $query;
    }

    public function devRequest(){
        return $this->BelongsTo(DevRequest::class,'request_id','id');
    }

}
