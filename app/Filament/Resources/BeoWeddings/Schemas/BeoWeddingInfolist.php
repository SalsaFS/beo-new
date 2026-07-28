<?php

namespace App\Filament\Resources\BeoWeddings\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class BeoWeddingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('details')
                    ->columns(2)
                    ->inlineLabel(true)
                    ->heading(false)
                    ->schema([
                        TextEntry::make('event_number'),
                        TextEntry::make('client.guest_number')
                            ->label('Client Number'),
                        TextEntry::make('client.telephone')
                            ->label('Tel'),
                        TextEntry::make('client.address')
                            ->wrap()
                            ->label('Address'),
                        TextEntry::make('client.mobile')
                            ->label('Mobile'),
                        TextEntry::make('client.pic')
                            ->label('PIC'),
                        TextEntry::make('guaranteed'),
                        TextEntry::make('date_of_function')
                            ->date('d F Y')
                            ->label('Date/Day/Time of Function'),
                        TextEntry::make('user.name')
                            ->label('In House Contact'),
                        TextEntry::make('beoWeddingPackages.package.name')
                            ->wrap()
                            ->label('Package'),
                        TextEntry::make('beoWeddingPackages.venue.name')
                            ->wrap()
                            ->label('Venue'),
                        TextEntry::make('beoWeddingMakeUps.venue.name')
                            ->wrap()
                            ->label('Make Up Room'),
                    ]),
                RepeatableEntry::make('function_table')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->state(function (RepeatableEntry $component) {
                        $record = $component->getRecord();
                        $rows = [];

                        foreach ($record->beoWeddingFunctions as $fn) {
                            $rows[] = [
                                'time' => $fn->time_start && $fn->time_end
                                    ? \Carbon\Carbon::parse($fn->time_start)->format('H:i') . '-' . \Carbon\Carbon::parse($fn->time_end)->format('H:i')
                                    : '',
                                'function' => $fn->function?->name,
                                'venue' => $fn->venue?->name,
                                'setup' => $fn->setup?->name,
                                'pax' => $fn->pax,
                            ];
                        }

                        return $rows;
                    })
                    ->table([
                        TableColumn::make('Time'),
                        TableColumn::make('Function'),
                        TableColumn::make('Venue'),
                        TableColumn::make('Setup'),
                        TableColumn::make('Pax'),
                    ])
                    ->schema([
                        TextEntry::make('time'),
                        TextEntry::make('function')
                            ->alignCenter()
                            ->weight(FontWeight::Bold),
                        TextEntry::make('venue'),
                        TextEntry::make('setup'),
                        TextEntry::make('pax'),
                    ]),
                Section::make('Signed')
                    ->heading(false)
                    ->schema([
                        TextEntry::make('signed')
                            ->label('SIGNED')
                            ->alignCenter()
                            ->formatStateUsing(fn($state) => "'{$state}'")
                            ->inlineLabel(true)
                            ->weight(FontWeight::Bold),
                    ]),
                Grid::make(5)
                    ->schema([
                        Section::make('Menu Note')
                            ->columnSpan(2)
                            ->heading(false)
                            ->schema([
                                RepeatableEntry::make('menu_items')
                                    ->label('Menu Note')
                                    ->columns(1)
                                    ->dense(true)
                                    ->contained(false)
                                    ->extraAttributes(['style' => 'display: flex; flex-direction: column; gap: 10px;'])
                                    ->getStateUsing(function (RepeatableEntry $component) {
                                        $record = $component->getRecord();
                                        $items = [];

                                        foreach ($record->beoWeddingFunctions as $function) {
                                            if (!$function->free_meal && $function->beoWeddingAdditionalMeals->isEmpty()) {
                                                continue;
                                            }

                                            $additionalMenus = [];
                                            foreach ($function->beoWeddingAdditionalMeals as $beoMenu) {
                                                $additionalMenus[] = [
                                                    'menu' => $beoMenu->menu_name,
                                                    'pax' => $beoMenu->pax,
                                                ];
                                            }

                                            $items[] = [
                                                'function' => $function->function?->name,
                                                'free' => $function->free_meal,
                                                'menus' => $additionalMenus,
                                            ];
                                        }

                                        return $items;
                                    })
                                    ->schema([
                                        TextEntry::make('function')
                                            ->hiddenLabel()
                                            ->columnSpanFull()
                                            ->weight(FontWeight::Bold)
                                            ->alignCenter(),
                                        RepeatableEntry::make('menus')
                                            ->columns(2)
                                            ->label('Additional')
                                            ->contained(false)
                                            ->dense(true)
                                            ->visible(function ($state) {
                                                return $state;
                                            })
                                            ->schema([
                                                TextEntry::make('menu')
                                                    ->hiddenLabel(),
                                                TextEntry::make('pax')
                                                    ->hiddenLabel()
                                                    ->formatStateUsing(fn($state) => "({$state} pax)"),
                                            ]),
                                        TextEntry::make('free')
                                            ->label('Free')
                                            ->columnSpanFull()
                                            ->visible(function ($state) {
                                                return $state;
                                            }),
                                    ]),
                                TextEntry::make('menu_list')
                                    ->html()
                                    ->extraAttributes(['class' => 'fi-prose']),
                                TextEntry::make('other_note')
                                    ->html()
                                    ->extraAttributes(['class' => 'fi-prose'])
                            ]),
                        Section::make('setup')
                            ->columnSpan(3)
                            ->heading(false)
                            ->schema([
                                TextEntry::make('setup_arrangements')
                                    ->html()
                                    ->extraAttributes([
                                        'class' => 'fi-prose',
                                        'style' => 'height: 500px; overflow: auto;'
                                    ]),
                            ])
                    ]),
                Grid::make(5)
                    ->schema([
                        Section::make('Billing')
                            ->columnSpan(2)
                            ->heading(false)
                            ->schema([
                                ViewEntry::make('billings')
                                    ->view('filament.beo.wedding.wedding-billing')
                            ]),
                        Section::make('Breakdown')
                            ->columnSpan(3)
                            ->heading(false)
                            ->schema([
                                ViewEntry::make('breakdowns')
                                    ->view('filament.beo.wedding.wedding-breakdown')
                            ])
                    ]),
            ]);
    }
}
