<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('guest')
                    ->required(),
                Select::make('platform_id')
                    ->relationship('platform', 'name')
                    ->required(),
                DatePicker::make('date_issued')
                    ->required(),
                Textarea::make('review')
                    ->required(),
            ]);
    }
}
