<?php

namespace App\Filament\Resources\MenuSubTypes;

use App\Filament\Resources\MenuSubTypes\Pages\ListMenuSubTypes;
use App\Filament\Resources\MenuSubTypes\Schemas\MenuSubTypeForm;
use App\Filament\Resources\MenuSubTypes\Tables\MenuSubTypesTable;
use App\Models\MenuSubType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MenuSubTypeResource extends Resource
{
    protected static ?string $model = MenuSubType::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Menu Sub Type';
    protected static ?string $pluralModelLabel = 'Menus Sub Types';
    protected static string|UnitEnum|null $navigationGroup = 'F&B Management';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return MenuSubTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MenuSubTypesTable::configure($table);
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
            'index' => ListMenuSubTypes::route('/'),
        ];
    }
}
