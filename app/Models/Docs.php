<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docs extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'file_id',
        'content',
        'status',
        'user_id',
        'type'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'docs';
}
