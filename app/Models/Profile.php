<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'nome', 'descricao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at',
    ];

    protected $table = 'profile';
}
