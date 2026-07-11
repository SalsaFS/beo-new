<?php

namespace App\Filament\Resources\MeetingRooms\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Schemas\Schema;

class MeetingRoomInfolist
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
                            TextEntry::make('dimension_p')
                                ->formatStateUsing(function ($record) {
                                    $totalArea = $record->dimension_p * $record->dimension_l;
                                    $formattedArea = number_format($totalArea, 0, ',', '.');

                                    return "{$record->dimension_p}m x {$record->dimension_l}m ({$formattedArea} m²)";
                                })
                                ->label('Dimension'),
                            TextEntry::make('ceiling_height')
                                ->label('Ceiling Height (m)'),
                        ])
                            ->columns(3),
                        ImageEntry::make('picture_path')
                            ->label('Picture')
                            ->placeholder('-'),
                        TextEntry::make('description')
                            ->placeholder('-'),
                    ]),
                RepeatableEntry::make('roomCapacities')
                    ->hiddenLabel()
                    ->columns(2)
                    ->table([
                        TableColumn::make('Setup'),
                        TableColumn::make('Capacity'),
                    ])
                    ->schema([
                        TextEntry::make('setup.name')
                            ->label('Setup'),
                        TextEntry::make('capacity')
                            ->label('Capacity'),
                    ]),
            ]);
    }
}
