<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoAmendmentPackage extends Model
{
    protected $table = 'beo_amendment_packages';
    protected $fillable = [
        'beo_amendment_id',
        'package_id',
        'venue_id',
        'setup_id',
        'pax',
        'billing_type',
    ]; 
    public function beoAmendment()
    {
        return $this->belongsTo(BeoAmendment::class, 'beo_amendment_id');
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
    public function amendmentBreakdowns()
    {
        return $this->hasMany(AmendmentBreakdown::class,'beo_amendment_package_id');
    }
}