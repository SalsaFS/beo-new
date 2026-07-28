<?php

namespace App\Filament\Resources\BeoAmendments\Tables;

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

class BeoAmendmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('beo.event_number')
                    ->label('Event Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('beo.client.company')
                    ->label('Company')
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name_of_event')
                    ->label('Event Name')
                    ->searchable(),
                TextColumn::make('date_change')
                    ->label('Date Change')
                    ->date('d F Y')
                    ->sortable(),
            ])
            ->filters([])
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
                        return $record->beoAmendmentApprovals()->where('is_verify', 0)->exists();
                    })
                    ->infolist(function ($record) {
                        return [
                            RepeatableEntry::make('beoAmendmentApprovals')
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
                                        ->color(fn ($state) => $state ? 'success' : 'danger'),
                                ]),
                        ];
                    }),
                    Action::make('printBeo')
                    ->hiddenLabel()
                    ->tooltip('Print BEO')
                    ->icon(Heroicon::Printer)
                    ->visible(function ($record) {
                        $approvals = $record->beoAmendmentApprovals;

                        return $approvals->isNotEmpty()
                            && $approvals->every(fn ($a) => $a->is_verify != 0);
                    })
                    ->action(function ($record) {
                        $filename = ($record->beo->event_number ?? '') . ' - Amendment ' . ($record->beo->client->company ?? '') . '.xlsx';

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\BeoAmendmentExport($record),
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
