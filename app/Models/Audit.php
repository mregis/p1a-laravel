<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audit extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'description', 'user_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'audit';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
