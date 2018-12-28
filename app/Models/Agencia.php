<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Agencia extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        "codigo",
        "nome",
        "endereco",
        "bairro",
        "cep",
        "cidade",
        "uf",
        "cd"
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'agencia';

    public function __toString()
    {
        return $this->codigo . ": " . $this->nome;
    }
}
