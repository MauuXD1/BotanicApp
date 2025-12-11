<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Planta\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Json;
use App\MoonShine\Resources\Planta\PlantaResource;

/**
 * @extends IndexPage<PlantaResource>
 */
class PlantaIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            // ID interno de Mongo (_id)
            ID::make()->sortable(),

            // ID de negocio
            Text::make('ID Taxon', 'taxonID')
                ->sortable()
                ->badge('purple'),

            // Nombre común desde PREVIEW
            Text::make('Nombre Común', 'preview.vernacularName')
                ->sortable()
                ->badge('green'),

            // Nombre científico desde PREVIEW
            Text::make('Nombre Científico', 'preview.scientificName')
                ->badge('blue'),

            // Familia taxonómica correcta (TAXONOMICO.family)
            Text::make('Familia', 'taxonomico.family')
                ->badge('gray'),
        ];
    }

    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}