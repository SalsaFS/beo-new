<?php

namespace App\Filament\Resources\FunctionModels;

use App\Filament\Resources\FunctionModels\Pages\ListFunctionModels;
use App\Filament\Resources\FunctionModels\Schemas\FunctionModelForm;
use App\Filament\Resources\FunctionModels\Tables\FunctionModelsTable;
use App\Models\FunctionModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FunctionModelResource extends Resource
{
    protected static ?string $model = FunctionModel::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Function';
    protected static ?string $pluralModelLabel = 'Functions';
    protected static string|UnitEnum|null $navigationGroup = 'Admin Tool';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return FunctionModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FunctionModelsTable::configure($table);
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
            'index' => ListFunctionModels::route('/'),
        ];
    }
}
