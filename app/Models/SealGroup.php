<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class SealGroup extends Pivot
{
    use SoftDeletes;

    protected $fillable = [
        'seal_id',
        'doc_id',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'seal_group';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doc()
    {
        return $this->belongsTo(Docs::class, 'doc_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seal()
    {
        return $this->belongsTo(Seal::class, 'seal_id');
    }
}
