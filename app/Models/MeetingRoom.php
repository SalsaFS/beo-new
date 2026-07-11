<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingRoom extends Model
{
    protected $table = 'meeting_rooms';
    protected $fillable = [
        'name',
        'dimension_p',
        'dimension_l',
        'ceiling_height',
        'picture_path',
        'description',
    ]; 
    public function roomCapacities()
    {
        return $this->hasMany(RoomCapacity::class,'meeting_room_id');
    }
}
