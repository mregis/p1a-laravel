<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Banks extends BaseModel
{
    protected $fillable = [
        'name',
        'cod_bank',
        'description'
    ];

    use SoftDeletes;
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'banks';
}
