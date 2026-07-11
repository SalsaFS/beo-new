<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientWedding extends Model
{
    protected $table = 'client_weddings';
    protected $fillable = [
        'guest_number',
        'pic',
        'address',
        'mobile',
        'telephone',
    ]; 
    public function beoWeddings()
    {
        return $this->hasMany(BeoWedding::class,'client_wedding_id');
    }
}
