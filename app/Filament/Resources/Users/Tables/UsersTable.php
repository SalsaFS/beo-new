<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                TextColumn::make('username')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->searchable(),
                TextColumn::make('position.name')
                    ->label('Position')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_active')
                    ->label('Active State')
                    ->badge()
                    ->color(function (int $state) {
                        return $state === 1 ? 'success' : 'danger';
                    })
                    ->formatStateUsing(function (int $state) {
                        if ($state === 1) {
                            return 'Active';
                        } else
                            return 'Inactive';
                    })
                    ->extraAttributes([
                        'style' => 'display: table;',
                    ])
                    ->sortable(),
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
                    ->hiddenLabel(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
