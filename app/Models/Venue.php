<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'venues';
    protected $fillable = [
        'name',
        'picture_path',
        'description',
    ]; 
    public function roomCapacities()
    {
        return $this->hasMany(RoomCapacity::class,'venue_id');
    }
    public function beoFunctions()
    {
        return $this->hasMany(BeoFunction::class,'venue_id');
    }
    public function beoFunctionPackages()
    {
        return $this->hasMany(BeoFunctionPackage::class,'venue_id');
    }
    public function beoPackages()
    {
        return $this->hasMany(BeoPackage::class,'venue_id');
    }
    public function beoWeddingFunctions()
    {
        return $this->hasMany(BeoWeddingFunction::class,'venue_id');
    }
    public function beoWeddingPackages()
    {
        return $this->hasMany(BeoWeddingPackage::class,'venue_id');
    }
    public function beoWeddingMakeUps()
    {
        return $this->hasMany(BeoWeddingMakeUp::class,'venue_id');
    }
    public function beoWeddings()
    {
        return $this->belongsToMany(BeoWedding::class, 'beo_wedding_make_ups', 'venue_id', 'beo_wedding_id');
    }
    public function beoAmendmentPackages()
    {
        return $this->hasMany(BeoAmendmentPackage::class,'venue_id');
    }
}
