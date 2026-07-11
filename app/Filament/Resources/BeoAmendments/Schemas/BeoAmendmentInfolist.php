<?php

namespace App\Filament\Resources\BeoAmendments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BeoAmendmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('beo_id')
                    ->numeric(),
                TextEntry::make('name_of_event'),
                TextEntry::make('contact_person')
                    ->placeholder('-'),
                TextEntry::make('contact')
                    ->placeholder('-'),
                TextEntry::make('date_change')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('other_before')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('other_after')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
