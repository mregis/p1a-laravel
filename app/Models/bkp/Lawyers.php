<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *  @SWG\Definition(
 *   definition="Lawyers",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *           @SWG\Property(property="id", type="integer"),
 *           @SWG\Property(property="name", type="string"),
 *           @SWG\Property(property="phone", type="string"),
 *           @SWG\Property(property="email", type="string"),
 *           @SWG\Property(property="rg", type="string"),
 *           @SWG\Property(property="cpf", type="string"),
 *           @SWG\Property(property="birth_date", type="string"),
 *           @SWG\Property(property="zipcode", type="string"),
 *           @SWG\Property(property="state", type="string"),
 *           @SWG\Property(property="city", type="string"),
 *           @SWG\Property(property="number", type="string"),
 *           @SWG\Property(property="address", type="string"),
 *           @SWG\Property(property="complement", type="string"),
 *           @SWG\Property(property="description", type="string"),
 *           @SWG\Property(property="oab", type="string"),
 *           @SWG\Property(property="created_at", type="string"),
 *           @SWG\Property(property="updated_at", type="string"),
 *           @SWG\Property(property="deleted_at", type="string"),
 *       )
 *   }
 * )
 */
class Lawyers extends BaseModel
{
    protected $fillable = [
    'name','phone','email','rg','cpf','birth_date','zipcode','state','city','number','address','complement','district','description','oab'
    ];
    protected $guarded  = [
    'id','created_at','updated_at','deleted_at'
    ];

    protected $table    = 'lawyers';

}
