<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Leitura extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leituras';

    protected $fillable = [
        'id',
        'lote_id',
        'user_id',
        'capalote',
        'presente',
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

}
