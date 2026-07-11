<?php

namespace App\Filament\Resources\ClientWeddings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClientWeddingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('guest_number')
                    ->required(),
                TextInput::make('pic')
                    ->required(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('mobile')
                    ->required(),
                TextInput::make('telephone')
                    ->tel()
                    ->required(),
            ]);
    }
}
