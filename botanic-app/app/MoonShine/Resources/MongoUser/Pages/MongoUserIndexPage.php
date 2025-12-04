<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MongoUser\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\MongoUser\MongoUserResource;
use MoonShine\Support\ListOf;
use Throwable;

/**
 * @extends IndexPage<MongoUserResource>
 */
class MongoUserIndexPage extends IndexPage
{
    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function columns(): array
    {
        return [
            // Define the columns for the index table here
        ];
    }

    protected function filters(): ListOf
    {
        return parent::filters();
    }

    protected function actions(): ListOf
    {
        return parent::actions();
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}