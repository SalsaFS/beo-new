<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoWeddingAdditionalMeal extends Model
{
    protected $table = 'beo_wedding_additional_meals';
    protected $fillable = [
        'beo_wedding_function_id',
        'menu_name',
        'pax',
        'rate',
        'remark',
    ]; 
    public function beoWeddingFunction()
    {
        return $this->belongsTo(BeoWeddingFunction::class, 'beo_wedding_function_id');
    } 
}