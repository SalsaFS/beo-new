<?php

namespace App\Filament\Resources\Ingredients;

use App\Filament\Resources\Ingredients\Pages\ListIngredients;
use App\Filament\Resources\Ingredients\Schemas\IngredientForm;
use App\Filament\Resources\Ingredients\Tables\IngredientsTable;
use App\Models\Ingredient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IngredientResource extends Resource
{
    protected static ?string $model = Ingredient::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Ingredient';
    protected static ?string $pluralModelLabel = 'Ingredients';
    protected static string|UnitEnum|null $navigationGroup = 'F&B Management';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return IngredientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IngredientsTable::configure($table);
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
            'index' => ListIngredients::route('/'),
        ];
    }
}
