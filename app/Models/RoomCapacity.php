<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCapacity extends Model
{
    protected $table = 'room_capacities';
    protected $fillable = [
        'meeting_room_id',
        'setup_id',
        'capacity',
    ]; 
    public function meetingRoom()
    {
        return $this->belongsTo(MeetingRoom::class, 'meeting_room_id');
    } 
    public function setup()
    {
        return $this->belongsTo(Setup::class, 'setup_id');
    } 
}
