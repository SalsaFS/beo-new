<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoWeddingBreakdownPosting extends Model
{
    protected $table = 'beo_wedding_breakdown_postings';
    protected $fillable = [
        'beo_wedding_id',
        'name',
        'amount',
        'rate',
        'remark',
        'revenue_type',
    ]; 
    public function beoWedding()
    {
        return $this->belongsTo(BeoWedding::class, 'beo_wedding_id');
    } 
}