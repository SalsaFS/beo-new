<?php

namespace App\Filament\Resources\ClientBeos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientBeoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('guest_number'),
                TextEntry::make('company'),
                TextEntry::make('pic'),
                TextEntry::make('address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('mobile'),
                TextEntry::make('telephone'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
