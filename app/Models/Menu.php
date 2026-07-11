<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'menu_sub_type_id',
        'menu_code_id',
        'menu_type_id',
        'menu_code_number',
        'name',
        'price',
        'how_to_make',
        'picture_path',
    ]; 
    public function menuSubType()
    {
        return $this->belongsTo(MenuSubType::class, 'menu_sub_type_id');
    } 
    public function menuCode()
    {
        return $this->belongsTo(MenuCode::class, 'menu_code_id');
    } 
    public function menuType()
    {
        return $this->belongsTo(MenuType::class, 'menu_type_id');
    } 
    public function recipes()
    {
        return $this->hasMany(Recipe::class,'menu_id');
    }
    public function beoMenus()
    {
        return $this->hasMany(BeoMenu::class,'menu_id');
    }
}
