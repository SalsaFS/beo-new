<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuSubType extends Model
{
    protected $table = 'menu_sub_types';
    protected $fillable = [
        'name',
    ];
}
