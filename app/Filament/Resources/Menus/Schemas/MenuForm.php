<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Illuminate\Validation\Rules\Unique;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                Grid::make(2)
                    ->schema([
                        Select::make('menu_code_id')
                            ->relationship('menuCode', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                            ])
                            ->preload()
                            ->searchable()
                            ->required(),
                        TextInput::make('menu_code_number')
                            ->unique(ignoreRecord: true)
                            ->required(),
                    ]),
                Grid::make(2)
                    ->schema([
                        Select::make('menu_type_id')
                            ->relationship('menuType', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                            ])
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('menu_sub_type_id')
                            ->relationship('menuSubType', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                            ])
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp'),
                Repeater::make('recipes')
                    ->relationship('recipes')
                    ->label('Recipe')
                    ->table([
                        TableColumn::make('Ingredient'),
                        TableColumn::make('Quantity'),
                        TableColumn::make('Unit'),
                    ])
                    ->schema([
                        Select::make('ingredient_id')
                            ->relationship(
                                name: 'ingredient',
                                titleAttribute: 'name',
                            )
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('article_code')
                                    ->unique(ignoreRecord: true)
                                    ->required(),
                            ])
                            ->preload()
                            ->searchable(),
                        TextInput::make('quantity'),
                        Select::make('unit_id')
                            ->relationship(
                                name: 'unit',
                                titleAttribute: 'name',
                            )
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                            ])
                            ->preload()
                            ->searchable(),
                    ])
                    ->columns(2)
                    ->addActionAlignment(Alignment::Center)
                    ->minItems(0)
                    ->defaultItems(0)
                    ->addActionLabel('Add Ingredient'),
                RichEditor::make('how_to_make'),
                FileUpload::make('picture_path')
                    ->label('Picture')
                    ->mimeTypeMap([
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                    ])
                    ->maxSize(2048)
                    ->helperText('Max size: 2MB. Allowed types: jpg, jpeg, png.')
                    ->image()
                    ->directory('menus'),
            ]);
    }
}
