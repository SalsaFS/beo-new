<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageBreakdown extends Model
{
    protected $table = 'package_breakdowns';
    protected $fillable = [
        'package_id',
        'function_id',
        'note',
    ]; 
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    } 
    public function function()
    {
        return $this->belongsTo(FunctionModel::class, 'function_id');
    } 
}
