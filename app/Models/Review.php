<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = [
        'platform_id',
        'guest',
        'date_issued',
        'review',
    ]; 
    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    } 
}
