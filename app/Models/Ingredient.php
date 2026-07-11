<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';
    protected $fillable = [
        'name',
        'article_code',
    ];
    public function recipes()
    {
        return $this->hasMany(Recipe::class,'ingredient_id');
    }
}
