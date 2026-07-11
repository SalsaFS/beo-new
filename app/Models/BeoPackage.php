<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoPackage extends Model
{
    protected $table = 'beos';
    protected $fillable = [
        'beo_id',
        'package_id',
        'venue_id',
        'setup_id',
        'pax',
        'billing_type',
    ];
    public function beo()
    {
        return $this->belongsTo(Beo::class, 'beo_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }
    public function setup()
    {
        return $this->belongsTo(Setup::class, 'setup_id');
    }
    public function internalBreakdowns()
    {
        return $this->hasMany(InternalBreakdown::class,'beo_package_id');
    }
}
