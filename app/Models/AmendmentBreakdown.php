<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmendmentBreakdown extends Model
{
    protected $table = 'amendment_breakdowns';
    protected $fillable = [
        'beo_amendment_package_id',
        'name',
        'pax',
        'rate',
        'remark',
    ]; 
    public function beoAmendmentPackage()
    {
        return $this->belongsTo(BeoAmendmentPackage::class, 'beo_amendment_package_id');
    } 
}