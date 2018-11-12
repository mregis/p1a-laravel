<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lending extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
          'name',
          'value',
          'max_quote',
          'rate',
          'contract',
          'active',
    ];
    protected $guarded = [
        'lending_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'lending';
}
