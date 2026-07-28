<?php

namespace App\Filament\Resources\BeoApprovals\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BeoApprovalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event_number')
                    ->label('Event Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client.company')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_of_function')
                    ->label('Date')
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
