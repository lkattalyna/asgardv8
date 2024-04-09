<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Builder;

class LoginLog extends Model
{
    protected $primaryKey = ['username', 'created_at'];
    public $incrementing = false;
    protected $guarded = [];

    /* protected function setKeysForSaveQuery(Builder $query)
    {
        foreach ($this->getKeyName() as $key) {
            // UPDATE: Added isset() per devflow's comment.
            if (isset($this->$key))
                $query->where($key, '=', $this->$key);
            else
                throw new Exception(__METHOD__ . 'Missing part of the primary key: ' . $key);
        }

        return $query;
    }  */

}
