<?php

namespace App\Filament\Resources\Venues\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                FileUpload::make('picture_path')
                    ->label('Picture')
                    ->directory('venue')
                    ->mimeTypeMap([
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                    ])
                    ->maxSize(2048)
                    ->helperText('Max size: 2MB. Allowed types: jpg, jpeg, png.')
                    ->image()
                    ->hidden(fn (?string $operation, $state) => $operation === 'view' && blank($state)),
                Textarea::make('description')
                    ->rows(5),
            ]);
    }
}