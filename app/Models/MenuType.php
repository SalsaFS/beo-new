<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuType extends Model
{
    protected $table = 'menu_types';
    protected $fillable = [
        'name',
    ];
}
