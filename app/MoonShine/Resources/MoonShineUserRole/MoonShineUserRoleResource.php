<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MoonShineUserRole;

use MoonShine\Laravel\Models\MoonshineUserRole;
use MoonShine\Laravel\Resources\ModelResource;
use App\MoonShine\Resources\MoonShineUserRole\Pages\MoonShineUserRoleFormPage;
use App\MoonShine\Resources\MoonShineUserRole\Pages\MoonShineUserRoleIndexPage;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Ability;

/**
 * @extends ModelResource<MoonshineUserRole, MoonShineUserRoleIndexPage, MoonShineUserRoleFormPage, null>
 */
#[Icon('bookmark')]
#[Group('moonshine::ui.resource.system', 'users', translatable: true)]
#[Order(1)]
class MoonShineUserRoleResource extends \MoonShine\Laravel\Resources\ModelResource
{
    
    protected string $model = MoonshineUserRole::class;

    protected string $column = 'name';

    protected bool $createInModal = true;

    protected bool $detailInModal = true;

    protected bool $editInModal = true;

    protected bool $cursorPaginate = true;

    public function getTitle(): string
    {
        return __('moonshine::ui.resource.role');
    }

    protected function activeActions(): \MoonShine\Support\ListOf
    {
        return parent::activeActions()->except(\MoonShine\Support\Enums\Action::VIEW);
    }

    protected function isCan(Ability $ability): bool
    {
        $user = auth('moonshine')->user();
        // Only administrators can manage roles
        return $user->moonshine_user_role_id === 1;
    }

    protected function pages(): array
    {
        return [
            MoonShineUserRoleIndexPage::class,
            MoonShineUserRoleFormPage::class,
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
