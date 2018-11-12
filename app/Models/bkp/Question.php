<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'description',
    ];
    protected $guarded = [
        'created_at', 'updated_at','deleted_at',
    ];

    protected $table = 'questions';

}
