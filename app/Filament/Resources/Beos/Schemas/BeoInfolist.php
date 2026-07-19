<?php

namespace App\Filament\Resources\Beos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BeoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('details')
                    ->heading(false)
                    ->schema([
                        ViewEntry::make('Details')
                            ->view('filament.beo.beo.beo-header')
                    ]),
                Grid::make(5)
                    ->schema([
                        Section::make('menu')
                            ->columnSpan(2)
                            ->heading(false)
                            ->schema([
                                ViewEntry::make('menu_note')
                                    ->view('filament.beo.beo.beo-menu'),
                            ])
                            ->extraAttributes(['class' => 'h-full']),
                        Section::make('setup')
                            ->columnSpan(3)
                            ->heading(false)
                            ->schema([
                                ViewEntry::make('setup_arrangement')
                                    ->view('filament.beo.beo.beo-setup')
                            ])
                            ->extraAttributes(['class' => 'h-full']),
                    ]),
            ]);
    }
}
