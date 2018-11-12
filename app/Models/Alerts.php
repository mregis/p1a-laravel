<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alerts extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'date_ref',
        'time_ref',
        'tipo',
        'type_id',
        'product_id',
        'desc',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'alerts';
}
