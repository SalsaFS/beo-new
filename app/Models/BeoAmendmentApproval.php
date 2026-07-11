<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoAmendmentApproval extends Model
{
    protected $table = 'beo_amendment_approvals';
    protected $fillable = [
        'beo_amendment_id',
        'user_id',
        'is_verify',
    ]; 
    public function beoAmendment()
    {
        return $this->belongsTo(BeoAmendment::class, 'beo_amendment_id');
    } 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
}