<?php

namespace App\Filament\Resources\Beos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client_beo_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('event_number')
                    ->searchable(),
                TextColumn::make('date_of_function')
                    ->date()
                    ->sortable(),
                TextColumn::make('guaranteed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('expected')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_information')
                    ->searchable(),
                TextColumn::make('signed')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
