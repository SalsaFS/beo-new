<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoWeddingPackage extends Model
{
    protected $table = 'beo_wedding_packages';
    protected $fillable = [
        'beo_wedding_id',
        'package_id',
        'venue_id',
        'setup_id',
        'pax',
    ]; 
    public function beoWedding()
    {
        return $this->belongsTo(BeoWedding::class, 'beo_wedding_id');
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
}