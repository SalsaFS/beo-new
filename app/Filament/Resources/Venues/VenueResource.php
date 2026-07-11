<?php

namespace App\Filament\Resources\Venues;

use App\Filament\Resources\Venues\Pages\ListVenues;
use App\Filament\Resources\Venues\Schemas\VenueForm;
use App\Filament\Resources\Venues\Tables\VenuesTable;
use App\Models\Venue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Venue';
    protected static ?string $pluralModelLabel = 'Venues';
    protected static string|UnitEnum|null $navigationGroup = 'Admin Tool';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return VenueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VenuesTable::configure($table);
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
            'index' => ListVenues::route('/'),
        ];
    }
}
