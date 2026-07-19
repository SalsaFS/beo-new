<?php

namespace App\Filament\Resources\ClientBeos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class ClientBeoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('guest_number')
                    ->required(),
                Group::make([
                    TextInput::make('company')
                        ->required(),
                    TextInput::make('pic')
                        ->label('PIC')
                        ->required(),
                ])
                    ->columns(2),
                Textarea::make('address')
                    ->columnSpanFull(),
                Group::make([
                    TextInput::make('mobile'),
                    TextInput::make('telephone')
                        ->tel(),
                ])
                    ->columns(2),
            ]);
    }
}
