<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoWedding extends Model
{
    protected $table = 'beo_weddings';
    protected $fillable = [
        'client_wedding_id',
        'user_id',
        'event_number',
        'date_of_function',
        'guaranteed',
        'expected',
        'setup_arrangements',
        'protocol',
        'payment_information',
        'payment_note',
        'other_note',
        'note',
        'signed',
        'menu_list',
        'deposit',
        'banquet',
    ]; 
    public function clientWedding()
    {
        return $this->belongsTo(ClientWedding::class, 'client_wedding_id');
    } 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
    public function beoWeddingFunctions()
    {
        return $this->hasMany(BeoWeddingFunction::class,'beo_wedding_id');
    }
    public function beoWeddingPackages()
    {
        return $this->hasMany(BeoWeddingPackage::class,'beo_wedding_id');
    }
    public function beoWeddingApprovals()
    {
        return $this->hasMany(BeoWeddingApproval::class,'beo_wedding_id');
    }
    public function beoWeddingAdditionalMeals()
    {
        return $this->hasMany(BeoWeddingAdditionalMeal::class,'beo_wedding_id');
    }
    public function beoWeddingBreakdownPostings()
    {
        return $this->hasMany(BeoWeddingBreakdownPosting::class,'beo_wedding_id');
    }
    public function beoWeddingMakeUps()
    {
        return $this->hasMany(BeoWeddingMakeUp::class,'beo_wedding_id');
    }
}
