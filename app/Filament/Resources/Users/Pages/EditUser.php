<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        unset($data['password_hash']);

        return $data;
    }
    protected function afterSave(): void
    {
        $record = $this->record;

        if (!$record->hasRole('approver')) {
            return;
        }

        if (!$record->is_active) {
            return;
        }
        User::where('position_id', $record->position_id)
            ->where('id', '!=', $record->id)
            ->where('is_active', 1)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'approver');
            })
            ->update(['is_active' => 0]);
    }
}
