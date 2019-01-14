<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'remember_token', 'city', 'profile', 'last_login', 'juncao', 'unidade'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];

    public function agencia() {
        return $this->belongsTo(Agencia::class, 'juncao', 'codigo');
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getLocal()
    {
        return ($this->juncao != null ? (string)$this->agencia() : ($this->unidade != null ? $this->unidade : '-'));
    }
}
