<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Lote extends BaseModel
{
    use SoftDeletes;

    /**
     * Model's types field basic entries
     */
    const STATE_OPEN = 'Aberto';
    const STATE_CLOSED = 'Finalizado';
    const STATE_ABORTED = 'Interrompido';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lotes';

    protected $fillable = [
        'id',
        'num_lote',
        'user_id',
        'unidade_id',
        'estado',
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
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }
}
