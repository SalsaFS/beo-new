<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BeoAmendment;
use Illuminate\Auth\Access\HandlesAuthorization;

class BeoAmendmentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BeoAmendment');
    }

    public function view(AuthUser $authUser, BeoAmendment $beoAmendment): bool
    {
        return $authUser->can('View:BeoAmendment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BeoAmendment');
    }

    public function update(AuthUser $authUser, BeoAmendment $beoAmendment): bool
    {
        return $authUser->can('Update:BeoAmendment');
    }

    public function delete(AuthUser $authUser, BeoAmendment $beoAmendment): bool
    {
        return $authUser->can('Delete:BeoAmendment');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:BeoAmendment');
    }

    public function restore(AuthUser $authUser, BeoAmendment $beoAmendment): bool
    {
        return $authUser->can('Restore:BeoAmendment');
    }

    public function forceDelete(AuthUser $authUser, BeoAmendment $beoAmendment): bool
    {
        return $authUser->can('ForceDelete:BeoAmendment');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BeoAmendment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BeoAmendment');
    }

    public function replicate(AuthUser $authUser, BeoAmendment $beoAmendment): bool
    {
        return $authUser->can('Replicate:BeoAmendment');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:BeoAmendment');
    }

}