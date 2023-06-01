<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Price;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the price can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the price can view the model.
     */
    public function view(User $user, Price $model): bool
    {
        return true;
    }

    /**
     * Determine whether the price can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the price can update the model.
     */
    public function update(User $user, Price $model): bool
    {
        return true;
    }

    /**
     * Determine whether the price can delete the model.
     */
    public function delete(User $user, Price $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the price can restore the model.
     */
    public function restore(User $user, Price $model): bool
    {
        return false;
    }

    /**
     * Determine whether the price can permanently delete the model.
     */
    public function forceDelete(User $user, Price $model): bool
    {
        return false;
    }
}
