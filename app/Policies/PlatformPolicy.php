<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Platform;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlatformPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Platform');
    }

    public function view(AuthUser $authUser, Platform $platform): bool
    {
        return $authUser->can('View:Platform');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Platform');
    }

    public function update(AuthUser $authUser, Platform $platform): bool
    {
        return $authUser->can('Update:Platform');
    }

    public function delete(AuthUser $authUser, Platform $platform): bool
    {
        return $authUser->can('Delete:Platform');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Platform');
    }

    public function restore(AuthUser $authUser, Platform $platform): bool
    {
        return $authUser->can('Restore:Platform');
    }

    public function forceDelete(AuthUser $authUser, Platform $platform): bool
    {
        return $authUser->can('ForceDelete:Platform');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Platform');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Platform');
    }

    public function replicate(AuthUser $authUser, Platform $platform): bool
    {
        return $authUser->can('Replicate:Platform');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Platform');
    }

}