<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('menu_sub_type_id')
                    ->required()
                    ->numeric(),
                TextInput::make('menu_code_id')
                    ->required()
                    ->numeric(),
                TextInput::make('menu_type_id')
                    ->required()
                    ->numeric(),
                TextInput::make('menu_code_number')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                Textarea::make('how_to_make')
                    ->columnSpanFull(),
                TextInput::make('picture_path'),
            ]);
    }
}
