<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientBeo extends Model
{
    protected $table = 'client_beos';
    protected $fillable = [
        'guest_number',
        'company',
        'pic',
        'address',
        'mobile',
        'telephone',
    ]; 
    public function beos()
    {
        return $this->hasMany(Beo::class,'client_beo_id');
    }
}
