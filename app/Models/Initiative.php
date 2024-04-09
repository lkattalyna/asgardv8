<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiative extends Model
{
    use HasFactory;

    protected $fillable = [
        'initiative_name',
        'segment_id',
        'service_layer_id',
        'how',
        'want',
        'for',
        'task_type',
        'state',
        'automation_type',
        'general_description',
        'execution_time_manual',
        'advantages',
        'attachments',
        'owner_id',
    ];
}
