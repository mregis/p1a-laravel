<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cities extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'cidade',
        'uf'
    ];
    protected $guarded = [
        'id_cidade', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'cities';
}
