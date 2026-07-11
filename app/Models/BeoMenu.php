<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoMenu extends Model
{
    protected $table = 'beo_menus';
    protected $fillable = [
        'beo_function_id',
        'menu_id',
        'pax',
    ]; 
    public function beoFunction()
    {
        return $this->belongsTo(BeoFunction::class, 'beo_function_id');
    } 
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    } 
}
