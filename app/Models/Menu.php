<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menus";

    protected $fillable = [
        'id',
        'name',
        'icon',
        'tag',
        'url',
        'item_order',
    ];

    public function sub_menus(){
        return $this->hasMany(Sub_Menu::class);
    }
    public function menu(){
        $menus = Menu::with('sub_menus')->orderBy('item_order')->get();
        return $menus;
    }
}
