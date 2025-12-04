<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MongoUser\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Email;
use Throwable;

/**
 * @extends IndexPage<\App\MoonShine\Resources\MongoUser\MongoUserResource>
 */
class MongoUserIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nombre', 'name')->sortable(),
            Email::make('Correo', 'email')->sortable(),
            Text::make('Creado', 'created_at')->sortable(),
        ];
    }

    /**
     * Permite ajustar el componente de tabla si necesitas columnas/acciones adicionales.
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        if ($component instanceof TableBuilder) {
            // ejemplo: $component->perPage(25);
        }

        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer(),
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer(),
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer(),
        ];
    }
}
