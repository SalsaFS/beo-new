<?php

namespace App\Filament\Resources\MenuTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MenuTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
