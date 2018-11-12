<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *   definition="Clients",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *          @SWG\Definition(
 *              @SWG\Property(property="parent_id", type="integer"),
 *              @SWG\Property(property="social_name", type="string"),
 *              @SWG\Property(property="fantasy_name", type="string"),
 *              @SWG\Property(property="cpf_cnpj", type="string"),
 *              @SWG\Property(property="rg", type="string"),
 *              @SWG\Property(property="state_registration", type="string"),
 *              @SWG\Property(property="municipal_registration", type="string"),
 *              @SWG\Property(property="financial_officer", type="string"),
 *              @SWG\Property(property="financial_phone", type="string"),
 *              @SWG\Property(property="financial_email", type="string"),
 *              @SWG\Property(property="zipcode", type="string"),
 *              @SWG\Property(property="state_id", type="string"),
 *              @SWG\Property(property="city", type="string"),
 *              @SWG\Property(property="number", type="string"),
 *              @SWG\Property(property="address", type="string"),
 *              @SWG\Property(property="district", type="string"),
 *              @SWG\Property(property="complement", type="string"),

 *       )
 *   }
 * )
 */
class Clients extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'social_name',
        'fantasy_name',
        'name',
        'rg',
        'cpf_cnpj',
        'state_registration',
        'municipal_registration',
        'financial_officer',
        'financial_phone',
        'financial_email',
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

    protected $table = 'clients';
}
