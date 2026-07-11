<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(['meeting' => 'Meeting', 'wedding' => 'Wedding'])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                        $repeaterItems = $get('packageBreakdowns') ?? [];

                        foreach ($repeaterItems as $key => $item) {
                            $set("packageBreakdowns.{$key}.function_id", null);
                        }
                    }),
                Textarea::make('description'),
                Repeater::make('packageBreakdowns')
                    ->relationship('packageBreakdowns')
                    ->label('Functions')
                    ->table([
                        TableColumn::make('Name'),
                        TableColumn::make('Note'),
                    ])
                    ->schema([
                        Select::make('function_id')
                            ->relationship(
                                name: 'function',
                                titleAttribute: 'name',
                                modifyQueryUsing: function (Builder $query, Get $get) {
                                    return $query->where('type', $get('../../type'));
                                }
                            )
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                                Select::make('type')
                                    ->options(['meeting' => 'Meeting', 'wedding' => 'Wedding'])
                                    ->default(function ($component, Get $get) {
                                        return $component->getContainer()->getLivewire()->data['type'] ?? null;
                                    })
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),
                            ])
                            ->preload()
                            ->searchable()
                            ->required(),
                        TextInput::make('note'),
                    ])
                    ->columns(2)
                    ->addActionAlignment(Alignment::End)
                    ->minItems(1)
                    ->addActionLabel('Add Function'),
            ]);
    }
}
