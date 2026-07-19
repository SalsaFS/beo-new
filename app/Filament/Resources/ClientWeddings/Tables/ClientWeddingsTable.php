<?php

namespace App\Filament\Resources\ClientWeddings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientWeddingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guest_number')
                    ->searchable(),
                TextColumn::make('pic')
                    ->label('PIC')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('mobile')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->hiddenLabel()
                    ->tooltip('View'),
                EditAction::make()
                    ->modal()
                    ->hiddenLabel()
                    ->tooltip('Edit'),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete')
                    ->before(function (DeleteAction $action, \App\Models\ClientBeo $record) {
                        if ($record->beos()->exists()) {
                            \Filament\Notifications\Notification::make()
                                ->title('Tidak dapat menghapus')
                                ->body('Data tidak dapat dihapus karena terdaftar di BEO')
                                ->danger()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function (DeleteBulkAction $action, \Illuminate\Database\Eloquent\Collection $records) {
                            $used = $records->filter(function ($record) {
                                return $record->beos()->exists();
                            });

                            if ($used->isNotEmpty()) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Tidak dapat menghapus')
                                    ->body('Data tidak dapat dihapus karena terdaftar di BEO.')
                                    ->danger()
                                    ->send();

                                $action->cancel();
                            }
                        }),
                ]),
            ]);
    }
}
