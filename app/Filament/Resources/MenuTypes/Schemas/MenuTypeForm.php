<?php

namespace App\Filament\Resources\MenuTypes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MenuTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('client_beo_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('event_number')
                    ->required(),
                DatePicker::make('date_of_function')
                    ->required(),
                TextInput::make('guaranteed')
                    ->numeric()
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
                TextInput::make('expected')
                    ->numeric()
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
                Textarea::make('setup_arrangements')
                    ->columnSpanFull()
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
                TextInput::make('payment_information')
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
                Textarea::make('other_note')
                    ->columnSpanFull()
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
                Textarea::make('note')
                    ->columnSpanFull()
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
                TextInput::make('signed')
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
            ]);
    }
}
