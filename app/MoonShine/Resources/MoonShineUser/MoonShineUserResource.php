<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MoonShineUser;

use MoonShine\Laravel\Models\MoonshineUser;
use MoonShine\Laravel\Resources\ModelResource;
use App\MoonShine\Resources\MoonShineUser\Pages\MoonShineUserFormPage;
use App\MoonShine\Resources\MoonShineUser\Pages\MoonShineUserIndexPage;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Ability;

/**
 * @extends ModelResource<MoonshineUser, MoonShineUserIndexPage, MoonShineUserFormPage, null>
 */
#[Icon('users')]
#[Group('moonshine::ui.resource.system', 'users', translatable: true)]
#[Order(0)]
class MoonShineUserResource extends \MoonShine\Laravel\Resources\ModelResource
{
    protected string $model = MoonshineUser::class;

    protected string $column = 'name';

    protected array $with = ['moonshineUserRole'];

    protected bool $simplePaginate = true;

    protected function isCan(Ability $ability): bool
    {
        $user = auth('moonshine')->user();
        return match ($ability) {
            Ability::VIEW_ANY, Ability::VIEW => in_array($user->moonshine_user_role_id, [1, 2]),
            Ability::CREATE => in_array($user->moonshine_user_role_id, [1, 2]),
            Ability::UPDATE => in_array($user->moonshine_user_role_id, [1, 2]),
            Ability::DELETE => in_array($user->moonshine_user_role_id, [1, 2]),
            default => false,
        };
    }

    public function getTitle(): string
    {
        return __('moonshine::ui.resource.admins_title');
    }

    protected function activeActions(): \MoonShine\Support\ListOf
    {
        return parent::activeActions()->except(\MoonShine\Support\Enums\Action::VIEW);
    }

    protected function pages(): array
    {
        return [
            MoonShineUserIndexPage::class,
            MoonShineUserFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
