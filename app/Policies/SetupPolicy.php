<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Setup;
use Illuminate\Auth\Access\HandlesAuthorization;

class SetupPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Setup');
    }

    public function view(AuthUser $authUser, Setup $setup): bool
    {
        return $authUser->can('View:Setup');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Setup');
    }

    public function update(AuthUser $authUser, Setup $setup): bool
    {
        return $authUser->can('Update:Setup');
    }

    public function delete(AuthUser $authUser, Setup $setup): bool
    {
        return $authUser->can('Delete:Setup');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Setup');
    }

    public function restore(AuthUser $authUser, Setup $setup): bool
    {
        return $authUser->can('Restore:Setup');
    }

    public function forceDelete(AuthUser $authUser, Setup $setup): bool
    {
        return $authUser->can('ForceDelete:Setup');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Setup');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Setup');
    }

    public function replicate(AuthUser $authUser, Setup $setup): bool
    {
        return $authUser->can('Replicate:Setup');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Setup');
    }

}