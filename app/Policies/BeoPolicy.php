<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Beo;
use Illuminate\Auth\Access\HandlesAuthorization;

class BeoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Beo');
    }

    public function view(AuthUser $authUser, Beo $beo): bool
    {
        return $authUser->can('View:Beo');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Beo');
    }

    public function update(AuthUser $authUser, Beo $beo): bool
    {
        return $authUser->can('Update:Beo');
    }

    public function delete(AuthUser $authUser, Beo $beo): bool
    {
        return $authUser->can('Delete:Beo');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Beo');
    }

    public function restore(AuthUser $authUser, Beo $beo): bool
    {
        return $authUser->can('Restore:Beo');
    }

    public function forceDelete(AuthUser $authUser, Beo $beo): bool
    {
        return $authUser->can('ForceDelete:Beo');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Beo');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Beo');
    }

    public function replicate(AuthUser $authUser, Beo $beo): bool
    {
        return $authUser->can('Replicate:Beo');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Beo');
    }

}