<?php

namespace App\Filament\Resources\BeoWeddingApprovals\Schemas;

use App\Models\Position;
use App\Models\User;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class BeoWeddingApprovalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Repeater::make('beoWeddingApprovals')
                    ->hiddenLabel()
                    ->saveRelationshipsUsing(function (Repeater $component, array $state) {
                        $record = $component->getRecord();
                        if (!$record) return;

                        $record->beoWeddingApprovals()->delete();

                        foreach ($state as $item) {
                            if (!empty($item['user_id'])) {
                                $record->beoWeddingApprovals()->create([
                                    'user_id' => $item['user_id'],
                                    'is_verify' => $item['is_verify'] ?? 0,
                                ]);
                            }
                        }
                    })
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('position_id')
                                    ->label('Position')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->options(fn () => Position::orderBy('signature_positions')
                                        ->pluck('name', 'id')),
                                Select::make('user_id')
                                    ->label('User')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->disabled(function (Get $get): bool {
                                        $positionId = $get('position_id');
                                        if ($positionId) {
                                            $position = Position::find($positionId);
                                            if ($position && $position->signature_positions == 1) {
                                                return true;
                                            }
                                        }
                                        $userId = $get('user_id');
                                        return $userId ? User::find($userId)?->hasRole('sales') : false;
                                    })
                                    ->options(function (Get $get) {
                                        $positionId = $get('position_id');
                                        if (!$positionId) {
                                            $userId = $get('user_id');
                                            if ($userId) {
                                                $user = User::find($userId);
                                                $positionId = $user?->position_id;
                                            }
                                        }
                                        if (!$positionId) return [];
                                        return User::where('position_id', $positionId)
                                            ->where('is_active', 1)
                                            ->pluck('name', 'id');
                                    }),
                                Select::make('is_verify')
                                    ->label('Status')
                                    ->options([
                                        0 => 'Not Verified',
                                        1 => 'Verified',
                                        2 => 'Manual Signed',
                                    ])
                                    ->default(0)
                                    ->required(),
                            ]),
                    ])
                    ->reorderable(false)
                    ->addable(false)
                    ->deleteAction(fn ($action) => $action->disabled())
                    ->itemLabel(fn (array $state): string =>
                        'Approver: ' . (($state['user_id'] ?? false) ? User::find($state['user_id'])?->name ?? 'Unknown' : 'New')
                    ),
            ]);
    }
}
