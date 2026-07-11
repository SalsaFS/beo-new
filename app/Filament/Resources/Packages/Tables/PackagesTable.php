<?php

namespace App\Filament\Resources\Packages\Tables;

use App\Models\PackageBreakdown;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PackagesTable
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
                TextColumn::make('packageBreakdowns.function.name')
                    ->badge()
                    ->color('gray'),
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
                    ->hiddenLabel()
                    ->tooltip('Edit'),
                DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->packageBreakdowns()->exists()) {
                            $record->packageBreakdowns()->delete();
                        }
                    })
                    ->hiddenLabel()
                    ->tooltip('Delete'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->packageBreakdowns()->exists()) {
                                    $record->packageBreakdowns()->delete();
                                }
                            }
                        }),
                ]),
            ]);
    }
}
