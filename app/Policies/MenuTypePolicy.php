<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MenuType;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MenuType');
    }

    public function view(AuthUser $authUser, MenuType $menuType): bool
    {
        return $authUser->can('View:MenuType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MenuType');
    }

    public function update(AuthUser $authUser, MenuType $menuType): bool
    {
        return $authUser->can('Update:MenuType');
    }

    public function delete(AuthUser $authUser, MenuType $menuType): bool
    {
        return $authUser->can('Delete:MenuType');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MenuType');
    }

    public function restore(AuthUser $authUser, MenuType $menuType): bool
    {
        return $authUser->can('Restore:MenuType');
    }

    public function forceDelete(AuthUser $authUser, MenuType $menuType): bool
    {
        return $authUser->can('ForceDelete:MenuType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MenuType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MenuType');
    }

    public function replicate(AuthUser $authUser, MenuType $menuType): bool
    {
        return $authUser->can('Replicate:MenuType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MenuType');
    }

}