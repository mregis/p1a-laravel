<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_Menu extends Model
{
    protected $table = "sub_menus";

    protected $fillable = [
        'id',
        'menu_id',
        'name',
        'icon',
        'tag',
        'url',
        'item_order',
    ];

    public function Menu(){
        return $this->belongsTo(Menu::class);
    }

}
