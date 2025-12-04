<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Planta;

use App\Models\Planta;
use App\MoonShine\Resources\Planta\Pages\PlantaIndexPage;
use App\MoonShine\Resources\Planta\Pages\PlantaFormPage;
use App\MoonShine\Resources\Planta\Pages\PlantaDetailPage;
use MoonShine\Core\Resources\Resource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Planta>
 */
class PlantaResource extends ModelResource
{
    protected string $model = Planta::class;

    protected string $title = 'Plantas';

    // Columna que se usará para identificar el recurso en relaciones o títulos
    protected string $column = 'plantaID';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PlantaIndexPage::class,
            PlantaFormPage::class,
        ];
    }

    /**
     * Reglas de validación básicas
     */
    public function rules(mixed $item): array
    {
        return [
            'plantaID' => ['required', 'string', 'max:255'],
        ];
    }
}