<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoWeddingApproval extends Model
{
    protected $table = 'beo_wedding_approvals';
    protected $fillable = [
        'beo_wedding_id',
        'user_id',
        'is_verify',
    ]; 
    public function beoWedding()
    {
        return $this->belongsTo(BeoWedding::class, 'beo_wedding_id');
    } 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
}