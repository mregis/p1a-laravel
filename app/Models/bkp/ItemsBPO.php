<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *   definition="ItemsBPO",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *           @SWG\Property(property="id", type="integer"),
 *           @SWG\Property(property="title", type="title"),
 *           @SWG\Property(property="description", type="string"),
 *           @SWG\Property(property="type_expertise_id", type="integer"),
 *           @SWG\Property(property="created_at", type="string"),
 *           @SWG\Property(property="updated_at", type="string"),
 *           @SWG\Property(property="deleted_at", type="string"),
 *       )
 *   }
 * )
 */
class ItemsBPO extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'title', 'description', 'type_expertise_id'
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'items_bpo';

    public function typeExpertise()
    {
        return $this->belongsTo(TypeExpertise::class);
    }

}
