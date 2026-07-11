<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ClientWedding;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientWeddingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ClientWedding');
    }

    public function view(AuthUser $authUser, ClientWedding $clientWedding): bool
    {
        return $authUser->can('View:ClientWedding');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ClientWedding');
    }

    public function update(AuthUser $authUser, ClientWedding $clientWedding): bool
    {
        return $authUser->can('Update:ClientWedding');
    }

    public function delete(AuthUser $authUser, ClientWedding $clientWedding): bool
    {
        return $authUser->can('Delete:ClientWedding');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ClientWedding');
    }

    public function restore(AuthUser $authUser, ClientWedding $clientWedding): bool
    {
        return $authUser->can('Restore:ClientWedding');
    }

    public function forceDelete(AuthUser $authUser, ClientWedding $clientWedding): bool
    {
        return $authUser->can('ForceDelete:ClientWedding');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ClientWedding');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ClientWedding');
    }

    public function replicate(AuthUser $authUser, ClientWedding $clientWedding): bool
    {
        return $authUser->can('Replicate:ClientWedding');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ClientWedding');
    }

}