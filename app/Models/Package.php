<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'name',
        'type',
        'description',
    ];
    public function packageBreakdowns()
    {
        return $this->hasMany(PackageBreakdown::class,'package_id');
    }
    public function beoPackages()
    {
        return $this->hasMany(BeoPackage::class,'package_id');
    }
}
