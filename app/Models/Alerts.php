<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alerts extends BaseModel
{
    use SoftDeletes;

    /**
     * Model's types field basic entries
     */
    const TYPE_READ_ERROR = 'ERRO LEITURA';
    const TYPE_TEST = 'TESTE';
    const TYPE_DOC_NOTFOUND_ERROR = 'CAPA LOTE INEXISTENTE';

    protected $fillable = [
        'user_id',
        'product_id',
        'type',
        'content',
        'description',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'alerts';


    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'product_id' => 1,
        'type' => self::TYPE_READ_ERROR
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
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
