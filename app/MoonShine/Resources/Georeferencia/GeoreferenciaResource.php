<?php

declare(strict_types=1);
namespace App\MoonShine\Resources\Georeferencia;

use MoonShine\Laravel\Resources\ModelResource;
use App\Models\Georeferencia;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Hidden;
use VisualStandard\MoonShineMapField\Fields\MapField;

class GeoreferenciaResource extends ModelResource
{
    protected string $model = Georeferencia::class;

    public function fields(): array
    {
        return [
            // Campos visibles
            Text::make('ID Ubicación', 'locationID')->required(),
            Text::make('Nombre Vernáculo en Sitio', 'vernacularName'),

            // EL MAPA
            MapField::make('Seleccionar Ubicación', 'map_location')
                ->lat('decimalLatitude')  // Campo en BD donde guardar Lat
                ->lng('decimalLongitude') // Campo en BD donde guardar Lng
                ->zoom(13)
                ->default([
                    'lat' => -0.201562,   // Coordenadas por defecto (Ecuador)
                    'lng' => -78.479427
                ]),

            // Campos ocultos o automáticos
            Hidden::make('taxonID'), // Se llenará con la relación
            Hidden::make('geodeticDatum')->default('WGS84'),
        ];
    }

    public function rules($item): array
    {
        return [];
    }
}
