<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionsLog extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'operation',
    ];
    protected $guarded = [
        'transaction_log_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'transactions_log';
}
