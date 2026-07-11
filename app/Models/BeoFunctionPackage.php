<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoFunctionPackage extends Model
{
    protected $table = 'beo_function_packages';
    protected $fillable = [
        'beo_id',
        'name',
        'venue_id',
        'setup_id',
        'time_start',
        'time_end',
        'pax',
    ]; 
    public function beo()
    {
        return $this->belongsTo(Beo::class, 'beo_id');
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
