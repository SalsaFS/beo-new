<?php

namespace App\Filament\Resources\MeetingRooms\Pages;

use App\Filament\Resources\MeetingRooms\MeetingRoomResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMeetingRoom extends ViewRecord
{
    protected static string $resource = MeetingRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
