<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoWeddingFunction extends Model
{
    protected $table = 'beo_wedding_functions';
    protected $fillable = [
        'beo_wedding_id',
        'function_id',
        'venue_id',
        'setup_id',
        'time_start',
        'time_end',
        'pax',
        'free_meal',
        'sort',
    ]; 
    public function beoWedding()
    {
        return $this->belongsTo(BeoWedding::class, 'beo_wedding_id');
    } 
    public function function()
    {
        return $this->belongsTo(FunctionModel::class, 'function_id');
    } 
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    } 
    public function setup()
    {
        return $this->belongsTo(Setup::class, 'setup_id');
    } 
    public function beoWeddingAdditionalMeals()
    {
        return $this->hasMany(BeoWeddingAdditionalMeal::class,'beo_wedding_function_id');
    }
}