<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionModel extends Model
{
    protected $table = 'functions';
    protected $fillable = [
        'name',
        'type',
        'description',
    ];
    public function packageBreakdowns()
    {
        return $this->hasMany(PackageBreakdown::class,'function_id');
    }
    public function beoFunctions()
    {
        return $this->hasMany(BeoFunction::class,'function_id');
    }
}
