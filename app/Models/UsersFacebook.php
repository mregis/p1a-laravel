<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersFacebook extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'link',
        'username',
        'gender',
        'email',
        'birthday',
        'timezone',
        'verified',
        'obs',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'users_facebook';
}
