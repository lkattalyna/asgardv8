<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vcenter extends Model
{
    protected $table = 'central.vcenter';
    protected $primaryKey = 'vcenterID';

    protected $fillable = [
        'vcenterID',
        'vcenterAlias',
        'fk_segmentID',
        'vcenterIp',
        'vcenterStatus',
        'rolesID',
        'vcenterVersion'
    ];
}