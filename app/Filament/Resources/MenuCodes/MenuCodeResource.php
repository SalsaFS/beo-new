<?php

namespace App\Filament\Resources\MenuCodes;

use App\Filament\Resources\MenuCodes\Pages\ListMenuCodes;
use App\Filament\Resources\MenuCodes\Schemas\MenuCodeForm;
use App\Filament\Resources\MenuCodes\Tables\MenuCodesTable;
use App\Models\MenuCode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MenuCodeResource extends Resource
{
    protected static ?string $model = MenuCode::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Menu Code';
    protected static ?string $pluralModelLabel = 'Menu Codes';
    protected static string|UnitEnum|null $navigationGroup = 'F&B Management';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return MenuCodeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MenuCodesTable::configure($table);
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
            'index' => ListMenuCodes::route('/'),
        ];
    }
}
