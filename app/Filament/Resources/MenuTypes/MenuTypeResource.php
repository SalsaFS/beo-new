<?php

namespace App\Filament\Resources\MenuTypes;

use App\Filament\Resources\MenuTypes\Pages\ListMenuTypes;
use App\Filament\Resources\MenuTypes\Schemas\MenuTypeForm;
use App\Filament\Resources\MenuTypes\Tables\MenuTypesTable;
use App\Models\MenuType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MenuTypeResource extends Resource
{
    protected static ?string $model = MenuType::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Menu Type';
    protected static ?string $pluralModelLabel = 'Menu Types';
    protected static string|UnitEnum|null $navigationGroup = 'F&B Management';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return MenuTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MenuTypesTable::configure($table);
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
            'index' => ListMenuTypes::route('/'),
        ];
    }
}
