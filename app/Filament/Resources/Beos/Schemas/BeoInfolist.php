<?php

namespace App\Filament\Resources\Beos\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class BeoInfolist
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
                        TextEntry::make('client.company')
                            ->label('Company'),
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
                        TextEntry::make('beoPackages.package.name')
                            ->label('Package'),
                        TextEntry::make('beoPackages.venue.name')
                            ->label('Venue'),
                    ]),
                RepeatableEntry::make('functions_and_packages')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->state(function (RepeatableEntry $component) {
                        $record = $component->getRecord();
                        $rows = [];

                        foreach ($record->beoFunctionPackages as $pkg) {
                            $rows[] = [
                                'time_start' => $pkg->time_start,
                                'time' => $pkg->time_start && $pkg->time_end
                                    ? \Carbon\Carbon::parse($pkg->time_start)->format('H:i') . '-' . \Carbon\Carbon::parse($pkg->time_end)->format('H:i')
                                    : '',
                                'function' => $pkg->name,
                                'venue' => $pkg->venue?->name,
                                'setup' => $pkg->setup?->name,
                                'pax' => $pkg->pax,
                            ];
                        }

                        foreach ($record->beoFunctions as $fn) {
                            $rows[] = [
                                'time_start' => $fn->time_start,
                                'time' => $fn->time_start && $fn->time_end
                                    ? \Carbon\Carbon::parse($fn->time_start)->format('H:i') . '-' . \Carbon\Carbon::parse($fn->time_end)->format('H:i')
                                    : '',
                                'function' => $fn->function?->name,
                                'venue' => $fn->venue?->name,
                                'setup' => $fn->setup?->name,
                                'pax' => $fn->pax,
                            ];
                        }

                        usort($rows, fn($a, $b) => $a['time_start'] <=> $b['time_start']);

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
                        TextEntry::make('function'),
                        TextEntry::make('venue'),
                        TextEntry::make('setup'),
                        TextEntry::make('pax'),
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
                                    ->extraAttributes(['style' => 'display: flex; flex-direction: column; gap: 8px;'])
                                    ->getStateUsing(function (RepeatableEntry $component) {
                                        $record = $component->getRecord();
                                        $items = [];

                                        foreach ($record->beoFunctions as $function) {
                                            $menus = [];
                                            foreach ($function->beoMenus as $beoMenu) {
                                                $menus[] = [
                                                    'menu' => $beoMenu->menu?->name,
                                                    'pax' => $beoMenu->pax,
                                                ];
                                            }

                                            $items[] = [
                                                'function' => $function->function?->name . ' (' . $function->banquet . ')',
                                                'addon' => $function->menu_addon,
                                                'menus' => $menus,
                                            ];
                                        }

                                        return $items;
                                    })
                                    ->schema([
                                        TextEntry::make('function')
                                            ->hiddenLabel()
                                            ->columnSpanFull()
                                            ->weight(FontWeight::Bold),
                                        RepeatableEntry::make('menus')
                                            ->columns(2)
                                            ->hiddenLabel()
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
                                        TextEntry::make('addon')
                                            ->hiddenLabel()
                                            ->columnSpanFull()
                                            ->visible(function ($state) {
                                                return $state;
                                            }),
                                    ]),
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
                                    ->view('filament.beo.beo.beo-billing')
                            ]),
                        Section::make('Breakdown')
                            ->columnSpan(3)
                            ->heading(false)
                            ->schema([
                                ViewEntry::make('breakdowns')
                                    ->view('filament.beo.beo.beo-breakdown')
                            ])
                    ]),
            ]);
    }
}
