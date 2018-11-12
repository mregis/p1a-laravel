<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'nickname',
        'cpf',
        'phone',
        'facebook',
        'date_agree',
        'card_name_holder',
        'card_name_print',
        'card_number',
        'card_validity',
        'card_cvv',
        'card_flag',
        'bank_name_holder',
        'bank_account',
        'bank_agency',
        'bank_cpf',
        'bank_type',
    ];
    protected $guarded = [
        'customer_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'customers';
}
