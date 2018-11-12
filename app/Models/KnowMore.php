<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class KnowMore extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'description',
    ];
    protected $guarded = [
        'know_more_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'know_more';
}
