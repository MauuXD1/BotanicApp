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
        return in_array($user->moonshine_user_role_id, [1, 2]); 
    }

    public function view(MoonshineUser $user, MoonshineUser $item): bool
    {
        return in_array($user->moonshine_user_role_id, [1, 2]);
    }

    public function create(MoonshineUser $user): bool
    {
        return in_array($user->moonshine_user_role_id, [1, 2]);
    }

    public function update(MoonshineUser $user, MoonshineUser $item): bool
    {
        return in_array($user->moonshine_user_role_id, [1, 2]);
    }

    public function delete(MoonshineUser $user, MoonshineUser $item): bool
    {
        return in_array($user->moonshine_user_role_id, [1, 2]);
    }

    public function restore(MoonshineUser $user, MoonshineUser $item): bool
    {
        return in_array($user->moonshine_user_role_id, [1, 2]);
    }

    public function forceDelete(MoonshineUser $user, MoonshineUser $item): bool
    {
        return in_array($user->moonshine_user_role_id, [1, 2]);
    }

    public function massDelete(MoonshineUser $user): bool
    {
        return true;
    }
}
