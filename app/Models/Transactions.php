<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'lending_id',
        'name',
        'status',
        'pagseguro_transation_id',
        'pagseguro_payment_method',
        'pagseguro_status',
    ];
    protected $guarded = [
        'transaction_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'transactions';
}
