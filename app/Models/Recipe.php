<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipes';
    protected $fillable = [
        'menu_id',
        'ingredient_id',
        'unit_id',
        'quantity',
    ]; 
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    } 
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    } 
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    } 
}
