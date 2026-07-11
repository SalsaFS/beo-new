<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCode extends Model
{
    protected $table = 'menu_codes';
    protected $fillable = [
        'name',
    ]; 
}
