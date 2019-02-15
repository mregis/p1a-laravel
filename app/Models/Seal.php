<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seal extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'content',
        'user_id',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'seal';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function docs()
    {
        return $this->belongsToMany(Docs::class)->using(SealGroup::class);
    }
}
