<?php

namespace App\Filament\Resources\FunctionModels\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FunctionModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(['meeting' => 'Meeting', 'wedding' => 'Wedding'])
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
                TextInput::make('description')
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
            ]);
    }
}
