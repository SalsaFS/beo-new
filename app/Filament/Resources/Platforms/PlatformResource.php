<?php

namespace App\Filament\Resources\Platforms;

use App\Filament\Resources\Platforms\Pages\ListPlatforms;
use App\Filament\Resources\Platforms\Schemas\PlatformForm;
use App\Filament\Resources\Platforms\Tables\PlatformsTable;
use App\Models\Platform;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlatformResource extends Resource
{
    protected static ?string $model = Platform::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Platform';
    protected static ?string $pluralModelLabel = 'Platforms';
    protected static string|UnitEnum|null $navigationGroup = 'Admin Tool';
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return PlatformForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlatformsTable::configure($table);
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
            'index' => ListPlatforms::route('/'),
        ];
    }
}
