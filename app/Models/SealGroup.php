<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class SealGroup extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'seal_id',
        'doc_id',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'seal_group';
}
