<?php

namespace App\Filament\Resources\FunctionModels\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FunctionModelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'success' => 'wedding',
                        'info' => 'meeting',
                    ])
                    ->extraAttributes([
                        'style' => 'display: table;',
                    ]),
                TextColumn::make('description')
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->modal()
                    ->hiddenLabel()
                    ->tooltip('View'),
                EditAction::make()
                    ->modal()
                    ->hiddenLabel()
                    ->tooltip('Edit'),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
