<?php

namespace App\Filament\Resources\Setups;

use App\Filament\Resources\Setups\Pages\ListSetups;
use App\Filament\Resources\Setups\Schemas\SetupForm;
use App\Filament\Resources\Setups\Tables\SetupsTable;
use App\Models\Setup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SetupResource extends Resource
{
    protected static ?string $model = Setup::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Setup';
    protected static ?string $pluralModelLabel = 'Setups';
    protected static string|UnitEnum|null $navigationGroup = 'Admin Tool';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return SetupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SetupsTable::configure($table);
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
            'index' => ListSetups::route('/'),
        ];
    }
}
