<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersSession extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'users_id',
        'session_id',
        'value',
    ];
    protected $guarded = [
        'users_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'users_session';
}
