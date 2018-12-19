<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Files extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'total',
        'user_id',
        'constante',
        'codigo',
        'movimento',
        'sequencial',
        'file_hash'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'files';

    public function docs(){
        return $this->hasMany(Docs::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
