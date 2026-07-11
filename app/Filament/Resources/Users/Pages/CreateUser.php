<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!auth()->user()->hasRole('super-admin')) {
            $superAdminRoleId = Role::where('name', 'super-admin')->value('id');

            if (in_array($superAdminRoleId, (array) ($data['roles'] ?? []))) {
                abort(403, 'Anda tidak diizinkan membuat user dengan role super-admin.');
            }
        }

        return $data;
    }
    protected function afterCreate(): void
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
