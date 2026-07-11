<?php

namespace App\Filament\Resources\MeetingRooms\Pages;

use App\Filament\Resources\MeetingRooms\MeetingRoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMeetingRoom extends CreateRecord
{
    protected static string $resource = MeetingRoomResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
