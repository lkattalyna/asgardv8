<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClusterDatastore extends Model
{
    protected $connection = 'central';
    protected $table = 'datastore';
    protected $primaryKey = 'datastoreID';
    protected $fillable = ['datastoreName'];
}
