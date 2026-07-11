<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoApproval extends Model
{
    protected $table = 'beo_approvals';
    protected $fillable = [
        'beo_id',
        'user_id',
        'is_verify',
    ]; 
    public function beo()
    {
        return $this->belongsTo(Beo::class, 'beo_id');
    } 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
}
