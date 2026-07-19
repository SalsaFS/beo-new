<?php

namespace App\Filament\Resources\Ingredients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IngredientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('article_code')
                    ->unique(ignoreRecord: true)
                    ->hidden(fn(?string $operation, $state) => $operation === 'view' && blank($state)),
            ]);
    }
}
