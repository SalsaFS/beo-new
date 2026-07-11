<?php

namespace App\Filament\Resources\Beos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BeoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_beo_id')
                    ->numeric(),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('event_number'),
                TextEntry::make('date_of_function')
                    ->date(),
                TextEntry::make('guaranteed')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('expected')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('setup_arrangements')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('payment_information')
                    ->placeholder('-'),
                TextEntry::make('other_note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('signed')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
