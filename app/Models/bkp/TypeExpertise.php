<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *   definition="TypeExpertise",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *           @SWG\Property(property="id", type="integer"),
 *           @SWG\Property(property="name", type="string"),
 *           @SWG\Property(property="description", type="string"),
 *           @SWG\Property(property="created_at", type="string"),
 *           @SWG\Property(property="updated_at", type="string"),
 *           @SWG\Property(property="deleted_at", type="string"),
 *       )
 *   }
 * )
 */
class TypeExpertise extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'name', 'description'
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'type_expertise';

}
