<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Track extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'doc',
        'user_id',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'track';
}
