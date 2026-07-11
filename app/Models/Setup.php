<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    protected $table = 'setups';
    protected $fillable = [
        'name',
        'picture_path',
        'description',
    ];
    public function roomCapacities()
    {
        return $this->hasMany(RoomCapacity::class,'setup_id');
    }
    public function beoFunctions()
    {
        return $this->hasMany(BeoFunction::class,'setup_id');
    }
    public function beoFunctionPackages()
    {
        return $this->hasMany(BeoFunctionPackage::class,'setup_id');
    }
    public function beoPackages()
    {
        return $this->hasMany(BeoPackage::class,'setup_id');
    }
    public function beoWeddingFunctions()
    {
        return $this->hasMany(BeoWeddingFunction::class,'setup_id');
    }
    public function beoWeddingPackages()
    {
        return $this->hasMany(BeoWeddingPackage::class,'setup_id');
    }
    public function beoAmendmentPackages()
    {
        return $this->hasMany(BeoAmendmentPackage::class,'setup_id');
    }
}
