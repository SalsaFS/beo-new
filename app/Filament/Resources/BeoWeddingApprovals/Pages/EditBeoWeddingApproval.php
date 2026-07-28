<?php

namespace App\Filament\Resources\BeoWeddingApprovals\Pages;

use App\Filament\Resources\BeoWeddingApprovals\BeoWeddingApprovalResource;
use App\Models\Position;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBeoWeddingApproval extends EditRecord
{
    protected static string $resource = BeoWeddingApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $existingPositionIds = $this->record->beoWeddingApprovals
            ->pluck('user.position_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $positions = Position::where(function ($q) use ($existingPositionIds) {
            $q->where('signature_positions', '!=', 1)
              ->orWhereIn('id', $existingPositionIds);
        })
            ->orderBy('signature_positions')
            ->get();

        $existingApprovals = $this->record->beoWeddingApprovals->keyBy(function ($item) {
            return $item->user?->position_id;
        });

        $data['beoWeddingApprovals'] = [];
        foreach ($positions as $position) {
            $approval = $existingApprovals->get($position->id);
            $data['beoWeddingApprovals'][] = [
                'position_id' => $position->id,
                'user_id' => $approval?->user_id,
                'is_verify' => $approval?->is_verify ?? 0,
            ];
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
