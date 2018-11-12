<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RatingAssistent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'question_id',
        'assistent_id',
        'note',
        'obs'
    ];
    protected $guarded = [
        'created_at', 'updated_at','deleted_at',
    ];

    protected $table = 'rating_assistent';
}
