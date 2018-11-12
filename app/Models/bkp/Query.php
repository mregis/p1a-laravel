<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class Query extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'name', 'description'
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'query';

}
