<?php

namespace App\Filament\Resources\MeetingRooms\Pages;

use App\Filament\Resources\MeetingRooms\MeetingRoomResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMeetingRoom extends EditRecord
{
    protected static string $resource = MeetingRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
