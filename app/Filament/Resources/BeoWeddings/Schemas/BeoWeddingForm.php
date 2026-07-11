<?php

namespace App\Filament\Resources\BeoWeddings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BeoWeddingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_wedding_id')
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
                    ->numeric(),
                TextInput::make('expected')
                    ->numeric(),
                Textarea::make('setup_arrangements')
                    ->columnSpanFull(),
                Textarea::make('protocol')
                    ->columnSpanFull(),
                TextInput::make('payment_information'),
                Textarea::make('payment_note')
                    ->columnSpanFull(),
                Textarea::make('other_note')
                    ->columnSpanFull(),
                Textarea::make('note')
                    ->columnSpanFull(),
                TextInput::make('signed'),
                Textarea::make('menu_list')
                    ->columnSpanFull(),
                TextInput::make('deposit')
                    ->numeric(),
                Select::make('banquet')
                    ->options(['as per chef' => 'As per chef', 'request' => 'Request', 'no meals' => 'No meals']),
            ]);
    }
}
