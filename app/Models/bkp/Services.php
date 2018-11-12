<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *  @SWG\Definition(
 *   definition="Services",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *           @SWG\Property(property="id", type="integer"),
 *           @SWG\Property(property="client_id", type="integer"),
 *           @SWG\Property(property="part", type="string"),
 *           @SWG\Property(property="status", type="string"),
 *           @SWG\Property(property="proc", type="string"),
 *           @SWG\Property(property="city", type="string"),
 *           @SWG\Property(property="created_at", type="string"),
 *           @SWG\Property(property="updated_at", type="string"),
 *           @SWG\Property(property="deleted_at", type="string"),
 *       )
 *   }
 * )
 */
class Services extends BaseModel
{
    protected $fillable = [
    'client_id','part','status','proc','city'
    ];
    protected $guarded  = [
    'id','created_at','updated_at','deleted_at'
    ];

    protected $table    = 'services';

}
