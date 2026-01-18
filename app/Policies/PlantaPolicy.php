<?php

namespace App\Policies;

use App\Models\Planta;
use MoonShine\Laravel\Models\MoonshineUser;
use Illuminate\Auth\Access\Response;

class PlantaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(MoonshineUser $user): bool
    {
        // Administrador, Profesor, Estudiante can view
        return in_array($user->moonshine_user_role_id, [1, 2, 3]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(MoonshineUser $user, Planta $planta): bool
    {
        return in_array($user->moonshine_user_role_id, [1, 2, 3]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(MoonshineUser $user): bool
    {
        // Administrador, Profesor, Estudiante can create
        return in_array($user->moonshine_user_role_id, [1, 2, 3]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(MoonshineUser $user, Planta $planta): bool
    {
        // Only Administrador and Profesor can update
        return in_array($user->moonshine_user_role_id, [1, 2]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(MoonshineUser $user, Planta $planta): bool
    {
        // Only Administrador and Profesor can delete
        return in_array($user->moonshine_user_role_id, [1, 2]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Planta $planta): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Planta $planta): bool
    {
        return false;
    }
}
