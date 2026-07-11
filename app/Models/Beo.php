<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beo extends Model
{
    protected $table = 'beos';
    protected $fillable = [
        'client_beo_id',
        'user_id',
        'event_number',
        'date_of_function',
        'guaranteed',
        'expected',
        'setup_arrangements',
        'payment_information',
        'note',
        'other_note',
        'signed',
    ]; 
    public function client()
    {
        return $this->belongsTo(ClientBeo::class, 'client_beo_id');
    } 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
    public function beoApprovals()
    {
        return $this->hasMany(BeoApproval::class,'beo_id');
    }
    public function beoFunctions()
    {
        return $this->hasMany(BeoFunction::class,'beo_id');
    }
    public function beoFunctionPackages()
    {
        return $this->hasMany(BeoFunctionPackage::class,'beo_id');
    }
    public function beoPackages()
    {
        return $this->hasMany(BeoPackage::class,'beo_id');
    }
    public function additionalBreakdowns()
    {
        return $this->hasMany(AdditionalBreakdown::class,'beo_id');
    }
}
