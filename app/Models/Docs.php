<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docs extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'file_id',
        'content',
        'status',
        'user_id',
        'type',
        'from_agency',
        'to_agency',
        'qtde_docs'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'pendente',
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'docs';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file() {
        return $this->belongsTo('App\Models\Files');
    }

}
