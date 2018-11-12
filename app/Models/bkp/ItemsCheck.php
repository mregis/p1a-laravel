<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *   definition="ItemsCheck",
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
class ItemsCheck extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'title', 'check', 'description', 'item_bpo_id', 'user_id', 'start_date', 'end_date'
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'items_check';

    public function itemBpo()
    {
        return $this->belongsTo(ItemsBPO::class, 'item_bpo_id');
    }

    public function typeExpertise()
    {
        return $this->hasOne(ItemsBPO::class, 'type_expertise_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
