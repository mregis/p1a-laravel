<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docs extends BaseModel
{
    use SoftDeletes;

    const STATE_SENT = 'enviado';
    const STATE_PENDING = 'pendente';
    const STATE_IN_TRANSIT = 'em_transito';
    const STATE_RECEIVED = 'recebido';
    const STATE_THEFT = 'roubado';
    const STATE_CONTINGENCY = 'contingencia';

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
    public function file()
    {
        return $this->belongsTo(Files::class, 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(DocsHistory::class, 'doc_id', 'id')->orderBy('created_at', 'asc');
    }

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
    public function origin()
    {
        return $this->belongsTo(Agencia::class, 'from_agency', 'codigo')->withDefault(
            ['nome' => 'Agência sem cadastro', 'codigo' => $this->from_agency,]
        );

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destin()
    {
        return $this->belongsTo(Agencia::class, 'to_agency', 'codigo')->withDefault(
            ['nome' => 'Agência sem cadastro', 'codigo' => $this->to_agency,]
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seals()
    {
        return $this->belongsToMany(Seal::class, 'seal_group', 'doc_id', 'seal_id');
    }
}
