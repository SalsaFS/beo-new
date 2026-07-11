<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoAmendment extends Model
{
    protected $table = 'beo_amendments';
    protected $fillable = [
        'beo_id',
        'name_of_event',
        'contact_person',
        'contact',
        'date_change',
        'other_before',
        'other_after',
    ]; 
    public function beo()
    {
        return $this->belongsTo(Beo::class, 'beo_id');
    } 
    public function beoAmendmentPackages()
    {
        return $this->hasMany(BeoAmendmentPackage::class,'beo_amendment_id');
    }
    public function beoAmendmentApprovals()
    {
        return $this->hasMany(BeoAmendmentApproval::class,'beo_amendment_id');
    }
    public function amendmentBreakdowns()
    {
        return $this->hasMany(AmendmentBreakdown::class,'beo_amendment_id');
    }
}