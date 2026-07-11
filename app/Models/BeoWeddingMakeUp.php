<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoWeddingMakeUp extends Model
{
    protected $table = 'beo_wedding_make_ups';
    protected $fillable = [
        'beo_wedding_id',
        'venue_id',
    ]; 
    public function beoWedding()
    {
        return $this->belongsTo(BeoWedding::class, 'beo_wedding_id');
    } 
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    } 
}