<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalBreakdown extends Model
{
    protected $table = 'internal_breakdowns';
    protected $fillable = [
        'beo_package_id',
        'name',
        'pax',
        'rate',
        'remark',
    ]; 
    public function beoPackage()
    {
        return $this->belongsTo(BeoPackage::class, 'beo_package_id');
    } 
}
