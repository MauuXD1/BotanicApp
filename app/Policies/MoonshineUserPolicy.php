<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use MoonShine\Laravel\Models\MoonshineUser;

class MoonshineUserPolicy
{
    use HandlesAuthorization;

    public function viewAny(MoonshineUser $user): bool
    {
        return true;//$user->MoonshineUserRole->name === 'Admin' ?? 'Profesor';
    }

    public function view(MoonshineUser $user, MoonshineUser $item): bool
    {
        return true;
    }

    public function create(MoonshineUser $user): bool
    {
        return true;
    }

    public function update(MoonshineUser $user, MoonshineUser $item): bool
    {
        return true;
    }

    public function delete(MoonshineUser $user, MoonshineUser $item): bool
    {
        return true;
    }

    public function restore(MoonshineUser $user, MoonshineUser $item): bool
    {
        return true;
    }

    public function forceDelete(MoonshineUser $user, MoonshineUser $item): bool
    {
        return true;
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return true;
    }
}
