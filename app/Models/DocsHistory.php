<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocsHistory extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'doc_id',
        'description',
        'user_id'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'docs_history';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doc() {
        return $this->belongsTo(Docs::class, 'doc_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(Users::class, 'user_id');
    }

}
