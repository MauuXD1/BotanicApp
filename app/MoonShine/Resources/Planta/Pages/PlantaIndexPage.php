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
            // El ID interno de Mongo
            ID::make()->sortable(),

            // Tu ID de negocio
            Text::make('ID Planta', 'plantaID')
                ->sortable()
                ->badge('purple'),

            // Intentamos mostrar el nombre común accediendo al JSON con notación de puntos.
            // Nota: Esto funciona si tu driver de BD soporta consultas JSON directas o si MoonShine lo procesa en PHP.
            // Si da error, usa el campo Json configurado como "asKey" o simplemente muestra el ID.
            Text::make('Nombre Común', 'PREVIEW.nombre_comun'),
            
            // Mostramos la familia taxonómica si existe
            Text::make('Familia', 'TAXONOMICO.familia')
                ->badge('gray'),
        ];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}