<?php

namespace App\Filament\Resources\Positions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('signature_positions')
                    ->numeric()
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
            ]);
    }
}
