<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PackageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Details')
                    ->columns(1)
                    ->schema([
                        Group::make([
                            TextEntry::make('name'),
                            TextEntry::make('type')
                                ->badge()
                                ->extraAttributes([
                                    'style' => 'display: table;', // Memaksa element menciut pas seukuran teks badge
                                ]),
                            TextEntry::make('description')
                                ->placeholder('-'),
                        ])
                            ->columns(3),
                    ]),
                RepeatableEntry::make('packageBreakdowns')
                    ->hiddenLabel()
                    ->columns(2)
                    ->table([
                        TableColumn::make('Function'),
                        TableColumn::make('Note'),
                    ])
                    ->schema([
                        TextEntry::make('function.name')
                            ->label('Function'),
                        TextEntry::make('note')
                            ->label('Note'),
                    ]),
            ]);
    }
}
