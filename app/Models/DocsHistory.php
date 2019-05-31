<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocsHistory extends BaseModel
{
    use SoftDeletes;

    const STATE_UPLOAD = "upload";
    const STATE_SENT = "capa_enviada";
    const STATE_RECEIVED = "capa_recebida";
    const STATE_IN_TRANSIT = "capa_em_transito";
    const STATE_CONTINGENCY = "contingenciamento";

    protected $fillable = [
        'doc_id',
        'description',
        'user_id',
        'unidade_id',
        'dt_leitura',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidade() {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function getLocal()
    {
        return ($this->unidade_id != null ? (string)$this->unidade : ($this->user->unidade != null ? $this->user->unidade : '-'));
    }
}
