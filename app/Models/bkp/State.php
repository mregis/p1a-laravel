<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = "states";

    protected $fillable = [
        'id',
        'name',
        'abbr',
    ];

    public function states()
    {
        $states = State::query()->orderBy('name')->pluck('name', 'abbr');
        return $states;
    }
}
