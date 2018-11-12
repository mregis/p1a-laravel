<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audit extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'desc',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'audit';
}
