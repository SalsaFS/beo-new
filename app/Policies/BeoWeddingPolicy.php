<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BeoWedding;
use Illuminate\Auth\Access\HandlesAuthorization;

class BeoWeddingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BeoWedding');
    }

    public function view(AuthUser $authUser, BeoWedding $beoWedding): bool
    {
        return $authUser->can('View:BeoWedding');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BeoWedding');
    }

    public function update(AuthUser $authUser, BeoWedding $beoWedding): bool
    {
        return $authUser->can('Update:BeoWedding');
    }

    public function delete(AuthUser $authUser, BeoWedding $beoWedding): bool
    {
        return $authUser->can('Delete:BeoWedding');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:BeoWedding');
    }

    public function restore(AuthUser $authUser, BeoWedding $beoWedding): bool
    {
        return $authUser->can('Restore:BeoWedding');
    }

    public function forceDelete(AuthUser $authUser, BeoWedding $beoWedding): bool
    {
        return $authUser->can('ForceDelete:BeoWedding');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BeoWedding');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BeoWedding');
    }

    public function replicate(AuthUser $authUser, BeoWedding $beoWedding): bool
    {
        return $authUser->can('Replicate:BeoWedding');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:BeoWedding');
    }

}