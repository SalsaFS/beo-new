<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalBreakdown extends Model
{
    protected $table = 'additional_breakdowns';
    protected $fillable = [
        'beo_id',
        'name',
        'billing_type',
        'rate',
        'remark',
    ]; 
    public function beo()
    {
        return $this->belongsTo(Beo::class, 'beo_id');
    } 
}
