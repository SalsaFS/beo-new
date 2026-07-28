<?php

namespace App\Filament\Resources\BeoAmendmentApprovals\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BeoAmendmentApprovalsTable
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
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_change')
                    ->label('Date Change')
                    ->date('d F Y')
                    ->sortable(),
                TextColumn::make('verified_approvals_count')
                    ->label('Verified')
                    ->badge()
                    ->getStateUsing(fn ($record) => ($record->verified_approvals_count ?? 0) . '/' . ($record->total_approvals_count ?? 0))
                    ->sortable(true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
