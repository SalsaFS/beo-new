<?php

namespace App\Filament\Resources\BeoAmendments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BeoAmendmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('beo_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name_of_event')
                    ->required(),
                TextInput::make('contact_person'),
                TextInput::make('contact'),
                DatePicker::make('date_change'),
                Textarea::make('other_before')
                    ->columnSpanFull(),
                Textarea::make('other_after')
                    ->columnSpanFull(),
            ]);
    }
}
