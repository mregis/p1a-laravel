<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Lote extends BaseModel
{
    use SoftDeletes;

    /**
     * Model's types field basic entries
     */
    const STATE_OPEN = 'aberto';
    const STATE_CLOSED = 'finalizado';
    const STATE_ABORTED = 'interrompido';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lotes';

    protected $fillable = [
        'id',
        'user_id',
        'unidade_id',
        'num_lote',
        'lacre',
        'estado',
        'created_at'
    ];

    protected $guarded = [
        'id', 'updated_at', 'deleted_at'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'estado' => self::STATE_OPEN
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

    /**
     * Get the leituras for the Lote.
     */
    public function leituras()
    {
        return $this->hasMany(Leitura::class);
    }
}
