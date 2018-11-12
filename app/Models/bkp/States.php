<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *   definition="States",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *           @SWG\Property(property="id", type="integer"),
 *           @SWG\Property(property="name", type="string"),
 *           @SWG\Property(property="abbr", type="string"),
 *           @SWG\Property(property="created_at", type="string"),
 *           @SWG\Property(property="updated_at", type="string"),
 *           @SWG\Property(property="deleted_at", type="string"),
 *       )
 *   }
 * )
 */
class States extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'abbr'
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'states';

}
