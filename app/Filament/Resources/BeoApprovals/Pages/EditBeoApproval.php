<?php

namespace App\Filament\Resources\BeoApprovals\Pages;

use App\Filament\Resources\BeoApprovals\BeoApprovalResource;
use App\Models\Position;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBeoApproval extends EditRecord
{
    protected static string $resource = BeoApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $existingPositionIds = $this->record->beoApprovals
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

        $existingApprovals = $this->record->beoApprovals->keyBy(function ($item) {
            return $item->user?->position_id;
        });

        $data['beoApprovals'] = [];
        foreach ($positions as $position) {
            $approval = $existingApprovals->get($position->id);
            $data['beoApprovals'][] = [
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
