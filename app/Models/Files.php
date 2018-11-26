<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Files extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'total',
        'user_id',
        'constante',
        'codigo',
        'dia',
        'mes',
        'ano',
        'sequencial',
        'file_hash'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'files';
}
