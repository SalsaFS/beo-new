<?php

namespace App\Filament\Resources\MeetingRooms;

use App\Filament\Resources\MeetingRooms\Pages\CreateMeetingRoom;
use App\Filament\Resources\MeetingRooms\Pages\EditMeetingRoom;
use App\Filament\Resources\MeetingRooms\Pages\ListMeetingRooms;
use App\Filament\Resources\MeetingRooms\Pages\ViewMeetingRoom;
use App\Filament\Resources\MeetingRooms\Schemas\MeetingRoomForm;
use App\Filament\Resources\MeetingRooms\Schemas\MeetingRoomInfolist;
use App\Filament\Resources\MeetingRooms\Tables\MeetingRoomsTable;
use App\Models\MeetingRoom;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MeetingRoomResource extends Resource
{
    protected static ?string $model = MeetingRoom::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Meeting Room';
    protected static ?string $pluralModelLabel = 'Meeting Rooms';
    protected static string|UnitEnum|null $navigationGroup = 'Admin Tool';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return MeetingRoomForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MeetingRoomInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeetingRoomsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeetingRooms::route('/'),
            'create' => CreateMeetingRoom::route('/create'),
            'view' => ViewMeetingRoom::route('/{record}'),
            'edit' => EditMeetingRoom::route('/{record}/edit'),
        ];
    }
}
