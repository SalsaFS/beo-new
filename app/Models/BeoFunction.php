<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoFunction extends Model
{
    protected $table = 'beo_functions';
    protected $fillable = [
        'beo_id',
        'function_id',
        'venue_id',
        'setup_id',
        'time_start',
        'time_end',
        'pax',
        'banquet',
        'menu_addon',
        'sort',
    ];
    public function beo()
    {
        return $this->belongsTo(Beo::class, 'beo_id');
    }
    public function function()
    {
        return $this->belongsTo(FunctionModel::class, 'function_id');
    }
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }
    public function setup()
    {
        return $this->belongsTo(Setup::class, 'setup_id');
    }    
    public function beoMenus()
    {
        return $this->hasMany(BeoMenu::class,'beo_function_id');
    }
}
