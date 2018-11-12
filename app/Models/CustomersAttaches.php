<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomersAttaches extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'attach',
    ];
    protected $guarded = [
        'attach_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'customers_attaches';
}
