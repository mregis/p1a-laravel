<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends BaseModel
{
    protected $fillable = [
        'name', 'email', 'password', 'remember_token', 'city', 'profile', 'last_login', 'juncao', 'unidade'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'users';

}
