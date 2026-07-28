<?php

namespace App\Filament\Resources\Beos\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event_number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('client.company')
                    ->wrap()
                    ->label('Company')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date_of_function')
                    ->date('d F Y')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->wrap()
                    ->label('Sales')
                    ->sortable()
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
                Action::make('approvals')
                    ->hiddenLabel()
                    ->tooltip('Approval Status')
                    ->icon(Heroicon::XCircle)
                    ->modalHeading('Approval Status')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->visible(function ($record) {
                        return $record->beoApprovals()->where('is_verify', 0)->exists();
                    })
                    ->infolist(function ($record) {
                        return [
                            RepeatableEntry::make('beoApprovals')
                                ->hiddenLabel()
                                ->table([
                                    TableColumn::make('Approver'),
                                    TableColumn::make('Verification'),
                                ])
                                ->schema([
                                    TextEntry::make('user.name')
                                        ->label('User'),
                                    TextEntry::make('is_verify')
                                        ->label('Status')
                                        ->formatStateUsing(function ($state) {
                                            return $state
                                                ? '✓ Verified'
                                                : '✗ Not Verified';
                                        })
                                        ->badge()
                                        ->color(fn($state) => $state ? 'success' : 'danger'),
                                ]),
                        ];
                    }),
                Action::make('printBeo')
                    ->hiddenLabel()
                    ->tooltip('Print BEO')
                    ->icon(Heroicon::Printer)
                    ->visible(function ($record) {
                        $approvals = $record->beoApprovals;

                        return $approvals->isNotEmpty()
                            && $approvals->every(fn($a) => $a->is_verify != 0);
                    })
                    ->action(function ($record) {
                        $filename = ($record->event_number ?? '') . ' - ' . ($record->client->company ?? '') . '.xlsx';

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\BeoExport($record),
                            $filename
                        );
                    }),
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
