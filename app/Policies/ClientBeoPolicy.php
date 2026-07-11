<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ClientBeo;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientBeoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ClientBeo');
    }

    public function view(AuthUser $authUser, ClientBeo $clientBeo): bool
    {
        return $authUser->can('View:ClientBeo');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ClientBeo');
    }

    public function update(AuthUser $authUser, ClientBeo $clientBeo): bool
    {
        return $authUser->can('Update:ClientBeo');
    }

    public function delete(AuthUser $authUser, ClientBeo $clientBeo): bool
    {
        return $authUser->can('Delete:ClientBeo');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ClientBeo');
    }

    public function restore(AuthUser $authUser, ClientBeo $clientBeo): bool
    {
        return $authUser->can('Restore:ClientBeo');
    }

    public function forceDelete(AuthUser $authUser, ClientBeo $clientBeo): bool
    {
        return $authUser->can('ForceDelete:ClientBeo');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ClientBeo');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ClientBeo');
    }

    public function replicate(AuthUser $authUser, ClientBeo $clientBeo): bool
    {
        return $authUser->can('Replicate:ClientBeo');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ClientBeo');
    }

}