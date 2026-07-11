<?php

namespace App\Filament\Resources\Beos;

use App\Filament\Resources\Beos\Pages\CreateBeo;
use App\Filament\Resources\Beos\Pages\EditBeo;
use App\Filament\Resources\Beos\Pages\ListBeos;
use App\Filament\Resources\Beos\Pages\ViewBeo;
use App\Filament\Resources\Beos\Schemas\BeoForm;
use App\Filament\Resources\Beos\Schemas\BeoInfolist;
use App\Filament\Resources\Beos\Tables\BeosTable;
use App\Models\Beo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BeoResource extends Resource
{
    protected static ?string $model = Beo::class;
    protected static ?string $recordTitleAttribute = 'event_number';
    protected static ?string $modelLabel = 'Beo';
    protected static ?string $pluralModelLabel = 'Beos';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return BeoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BeoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeosTable::configure($table);
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
            'index' => ListBeos::route('/'),
            'create' => CreateBeo::route('/create'),
            'view' => ViewBeo::route('/{record}'),
            'edit' => EditBeo::route('/{record}/edit'),
        ];
    }
}
