<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'description',
        'mod',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'products';
}
