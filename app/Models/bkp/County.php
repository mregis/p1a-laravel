<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *  @SWG\Definition(
 *   definition="County",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *           @SWG\Property(property="id", type="integer"),
 *           @SWG\Property(property="name", type="string"),
 *           @SWG\Property(property="city", type="string"),
 *           @SWG\Property(property="state", type="string"),
 *           @SWG\Property(property="description", type="string"),
 *           @SWG\Property(property="created_at", type="string"),
 *           @SWG\Property(property="updated_at", type="string"),
 *           @SWG\Property(property="deleted_at", type="string"),
 *       )
 *   }
 * )
 */
class County extends BaseModel
{
    use SoftDeletes;
    protected $fillable = [
    'name','city','state','description'
    ];
    protected $guarded  = [
    'id','created_at','updated_at','deleted_at'
    ];

    protected $table    = 'county';

}
