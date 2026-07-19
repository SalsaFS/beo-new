<?php

namespace App\Filament\Resources\ClientWeddings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class ClientWeddingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('guest_number')
                    ->required(),
                TextInput::make('pic')
                    ->label('PIC')
                    ->required(),
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
