<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class Diary extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'status',
        'start',
        'end',
        'title',
        'color',
        'address',
        'lat',
        'long'
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'diary';

}
