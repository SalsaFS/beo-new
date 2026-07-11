<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;
    protected $table = 'users';
    protected $fillable = [
        'position_id',
        'name',
        'username',
        'password_hash',
        'picture_path',
        'signature',
        'is_active',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    public function beos()
    {
        return $this->hasMany(Beo::class, 'user_id');
    }
    public function beoWeddings()
    {
        return $this->hasMany(BeoWedding::class, 'user_id');
    }
    public function beoApprovals()
    {
        return $this->hasMany(BeoApproval::class, 'user_id');
    }
    public function beoAmendmentApprovals()
    {
        return $this->hasMany(BeoAmendmentApproval::class, 'user_id');
    }
    public function beoWeddingApprovals()
    {
        return $this->hasMany(BeoWeddingApproval::class, 'user_id');
    }
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
