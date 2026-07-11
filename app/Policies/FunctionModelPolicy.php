<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\FunctionModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class FunctionModelPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FunctionModel');
    }

    public function view(AuthUser $authUser, FunctionModel $functionModel): bool
    {
        return $authUser->can('View:FunctionModel');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FunctionModel');
    }

    public function update(AuthUser $authUser, FunctionModel $functionModel): bool
    {
        return $authUser->can('Update:FunctionModel');
    }

    public function delete(AuthUser $authUser, FunctionModel $functionModel): bool
    {
        return $authUser->can('Delete:FunctionModel');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:FunctionModel');
    }

    public function restore(AuthUser $authUser, FunctionModel $functionModel): bool
    {
        return $authUser->can('Restore:FunctionModel');
    }

    public function forceDelete(AuthUser $authUser, FunctionModel $functionModel): bool
    {
        return $authUser->can('ForceDelete:FunctionModel');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FunctionModel');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FunctionModel');
    }

    public function replicate(AuthUser $authUser, FunctionModel $functionModel): bool
    {
        return $authUser->can('Replicate:FunctionModel');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FunctionModel');
    }

}