<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *  @SWG\Definition(
 *   definition="Services_Aux",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *           @SWG\Property(property="id", type="integer"),
 *           @SWG\Property(property="service_id", type="integer"),
 *           @SWG\Property(property="type_id", type="integer"),
 *           @SWG\Property(property="status", type="string"),
 *           @SWG\Property(property="data", type="string"),
 *           @SWG\Property(property="description", type="string"),
 *           @SWG\Property(property="file", type="string"),
 *           @SWG\Property(property="created_at", type="string"),
 *           @SWG\Property(property="updated_at", type="string"),
 *           @SWG\Property(property="deleted_at", type="string"),
 *       )
 *   }
 * )
 */
class ServicesAux extends BaseModel
{
    protected $fillable = [
    'service_id','type_id','status','data','description','file'
    ];
    protected $guarded  = [
    'id','created_at','updated_at','deleted_at'
    ];

    protected $table    = 'services_aux';

}
