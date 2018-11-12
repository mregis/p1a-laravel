<?php

namespace App\Models;

use App\RatingAssistent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assistent extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'number_county',
        'name',
        'cell_phone',
        'phone',
        'email',
        'value',
        'cpf',
        'signature',
        'active',
        'number_account',
        'cod_agencia',
        'account_manager',
        'obs',
        'zipcode',
        'state',
        'city',
        'number',
        'address',
        'complement',
        'district',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'assistent';

    public function ratingAssistent()
    {
        return $this->hasMany(RatingAssistent::class);
    }
}
