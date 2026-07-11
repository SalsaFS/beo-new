<?php

namespace App\Filament\Resources\Setups\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SetupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                FileUpload::make('picture_path')
                    ->image()
                    ->mimeTypeMap([
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                    ])
                    ->maxSize(2048)
                    ->helperText('Max file size: 2MB | Allowed file types: jpg, jpeg, png')
                    ->directory('setup')
                    ->hidden(fn(?string $operation, $state) => $operation === 'view' && blank($state)),
                TextInput::make('description')
                    ->hidden(fn(?string $operation, $state) => $operation === 'view' && blank($state)),
            ]);
    }
}
