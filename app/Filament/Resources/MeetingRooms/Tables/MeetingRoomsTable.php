<?php

namespace App\Filament\Resources\MeetingRooms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MeetingRoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('dimension_p')
                    ->label('Dimension')
                    ->formatStateUsing(function ($record) {
                        $totalArea = $record->dimension_p * $record->dimension_l;
                        $formattedArea = number_format($totalArea, 0, ',', '.');

                        return "{$record->dimension_p}m x {$record->dimension_l}m ({$formattedArea} m²)";
                    })
                    ->sortable(query: function (\Illuminate\Database\Eloquent\Builder $query, string $direction) {
                        return $query->orderByRaw('(dimension_p * dimension_l) ' . $direction);
                    }),
                TextColumn::make('ceiling_height')
                    ->label('Ceiling Height (m)')
                    ->sortable(),
                TextColumn::make('description')
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->hiddenLabel()
                    ->tooltip('View'),
                EditAction::make()
                    ->tooltip('Edit')
                    ->hiddenLabel(),
                DeleteAction::make()
                    ->tooltip('Delete')
                    ->hiddenLabel()
                    ->before(function ($record) {
                        $record->roomCapacities()->delete();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                $record->roomCapacities()->delete();
                            }
                        }),
                ]),
            ]);
    }
}
