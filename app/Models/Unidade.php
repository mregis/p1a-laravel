<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Unidade extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'descricao',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at',
    ];

    protected $table = 'unidades';

    public function __toString()
    {
        return $this->nome;
    }
}
