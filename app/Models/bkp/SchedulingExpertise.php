<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class SchedulingExpertise extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'date',
        'zipcode',
        'state',
        'city',
        'number',
        'address',
        'complement',
        'scheduling_notification',
        'notification',
        'lawyer_id',
        'expert_name',
        'expert_phone',
        'expert_email',
        'assistent_name',
        'assistent_phone',
        'assistent_email',
        'assistent_value',
        'obs',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'scheduling_expertise';
}
