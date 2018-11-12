<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Accounts extends BaseModel
{
    use SoftDeletes;
    protected $fillable = [
        'bank_id',
        'code_sisfin',
        'account_manager',
        'obs',
        'number_account',
        'account_digit',
        'document',
        'name',
        'fantasy_name',
        'cod_agencia',
        'type_account',
        'holder'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'accounts';

    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bank_id');
    }
}
