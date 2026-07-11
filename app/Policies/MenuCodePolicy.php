<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MenuCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuCodePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MenuCode');
    }

    public function view(AuthUser $authUser, MenuCode $menuCode): bool
    {
        return $authUser->can('View:MenuCode');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MenuCode');
    }

    public function update(AuthUser $authUser, MenuCode $menuCode): bool
    {
        return $authUser->can('Update:MenuCode');
    }

    public function delete(AuthUser $authUser, MenuCode $menuCode): bool
    {
        return $authUser->can('Delete:MenuCode');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MenuCode');
    }

    public function restore(AuthUser $authUser, MenuCode $menuCode): bool
    {
        return $authUser->can('Restore:MenuCode');
    }

    public function forceDelete(AuthUser $authUser, MenuCode $menuCode): bool
    {
        return $authUser->can('ForceDelete:MenuCode');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MenuCode');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MenuCode');
    }

    public function replicate(AuthUser $authUser, MenuCode $menuCode): bool
    {
        return $authUser->can('Replicate:MenuCode');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MenuCode');
    }

}