<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MenuSubType;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuSubTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MenuSubType');
    }

    public function view(AuthUser $authUser, MenuSubType $menuSubType): bool
    {
        return $authUser->can('View:MenuSubType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MenuSubType');
    }

    public function update(AuthUser $authUser, MenuSubType $menuSubType): bool
    {
        return $authUser->can('Update:MenuSubType');
    }

    public function delete(AuthUser $authUser, MenuSubType $menuSubType): bool
    {
        return $authUser->can('Delete:MenuSubType');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MenuSubType');
    }

    public function restore(AuthUser $authUser, MenuSubType $menuSubType): bool
    {
        return $authUser->can('Restore:MenuSubType');
    }

    public function forceDelete(AuthUser $authUser, MenuSubType $menuSubType): bool
    {
        return $authUser->can('ForceDelete:MenuSubType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MenuSubType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MenuSubType');
    }

    public function replicate(AuthUser $authUser, MenuSubType $menuSubType): bool
    {
        return $authUser->can('Replicate:MenuSubType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MenuSubType');
    }

}