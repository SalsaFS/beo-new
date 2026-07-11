<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MenuInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('menu_sub_type_id')
                    ->numeric(),
                TextEntry::make('menu_code_id')
                    ->numeric(),
                TextEntry::make('menu_type_id')
                    ->numeric(),
                TextEntry::make('menu_code_number'),
                TextEntry::make('name'),
                TextEntry::make('price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('how_to_make')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('picture_path')
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
