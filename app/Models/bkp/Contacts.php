<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class Contacts extends BaseModel
{
    protected $fillable = [
        'client_id',
        'name',
        'email',
        'type',
        'status',
        'cpf',
        'rg',
        'birth_date',
        'cell_phone',
        'phone',
        'fax',
        'zipcode',
        'state',
        'city',
        'number',
        'address',
        'complement',
        'district',
        'description',
        'image',
    ];
    use SoftDeletes;
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $table = 'contacts';

        public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
}
