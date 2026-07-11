<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';
    protected $fillable = [
        'name',
    ];
    public function recipes()
    {
        return $this->hasMany(Recipe::class,'unit_id');
    }
}
