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
use MoonShine\ImportExport\Contracts\HasImportExportContract;
use MoonShine\ImportExport\Traits\ImportExportConcern;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\Support\Enums\Ability;
/**
 * @extends ModelResource<Planta>
 */
#[Icon('table-cells')]
class PlantaResource extends \MoonShine\Laravel\Resources\ModelResource implements HasImportExportContract
{

    use ImportExportConcern;

    protected string $model = Planta::class;
    protected string $title = 'Plantas';
    // Columna que se usará para identificar el recurso en relaciones o títulos
    protected string $column = 'plantaID';

    protected function isCan(Ability $ability): bool
    {
        $user = auth('moonshine')->user();
        return match ($ability) {
            Ability::VIEW_ANY, Ability::VIEW => in_array($user->moonshine_user_role_id, [1, 2, 3]),
            Ability::CREATE => in_array($user->moonshine_user_role_id, [1, 2, 3]),
            Ability::UPDATE => in_array($user->moonshine_user_role_id, [1, 2, 3]),
            Ability::DELETE => in_array($user->moonshine_user_role_id, [1, 2]),
            default => false,
        };
    }

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

    public function exportFields(): iterable
    {
        return [
            // Text::make('ID Planta', 'plantaID'),

            // // Usamos notación de punto con minúsculas
            // Text::make('Nombre Común', 'preview.vernacularName'),
            // Text::make('Nombre Científico', 'preview.scientificName'),
            
            // // Taxonomía
            // Text::make('Familia', 'taxonomico.family'),
            // Text::make('Género', 'taxonomico.genus'),
            // Text::make('Especie', 'taxonomico.especie'),

            //INTENTO 2

            // 1. ID y General (PROBABLEMENTE SE QUITE ESTE ID PLANTA)
            Text::make('ID Taxon', 'taxonID'),

            // --- GRUPO PREVIEW ---
            Text::make('Nombre Común', 'preview.vernacularName'),
            Text::make('Nombre Científico', 'preview.scientificName'),
            Text::make('Nombre Shuar', 'preview.shuarName'),
            Text::make('Descripción', 'preview.descripcion'),
            Text::make('Imagen URL', 'preview.imagen'),

            // --- GRUPO TAXONOMICO ---
            Text::make('ID del Taxon', 'taxonomico.taxonID'),
            Text::make('Reino', 'taxonomico.kingdom'),
            Text::make('División', 'taxonomico.phylum'),
            Text::make('Clase', 'taxonomico.class'),
            Text::make('Subclase', 'taxonomico.subclass'),
            Text::make('Super Orden', 'taxonomico.superOrder'),
            Text::make('Orden', 'taxonomico.order'),
            Text::make('Suborden', 'taxonomico.suborder'),
            Text::make('Familia', 'taxonomico.family'),
            Text::make('Género', 'taxonomico.genus'),
            Text::make('Especie', 'taxonomico.especie'),
        ];
    }
    public function importFields(): iterable
    {
        return [
            // Text::make('ID Planta', 'plantaID'),
            
            // // Mapeo inverso para guardar
            // Text::make('Nombre Común', 'preview.vernacularName'),
            // Text::make('Nombre Científico', 'preview.scientificName'),
            
            // Text::make('Familia', 'taxonomico.family'),
            // Text::make('Género', 'taxonomico.genus'),
            // Text::make('Especie', 'taxonomico.especie'),

            //INTENTO 2 (PROBABLEMENTE SE QUITE ESTE ID PLANTA)
            // Text::make('ID Planta', 'plantaID'),

            // // --- GRUPO PREVIEW ---
            // Text::make('Nombre Común', 'preview.vernacularName'),
            // Text::make('Nombre Científico', 'preview.scientificName'),
            // Text::make('Descripción', 'preview.descripcion'),
            // Text::make('Imagen URL', 'preview.imagen'),

            // // --- GRUPO TAXONOMICO ---
            // Text::make('Reino', 'taxonomico.kingdom'),
            // Text::make('División', 'taxonomico.phylum'),
            // Text::make('Clase', 'taxonomico.class'),
            // Text::make('Orden', 'taxonomico.order'),
            // Text::make('Familia', 'taxonomico.family'),
            // Text::make('Género', 'taxonomico.genus'),
            // Text::make('Especie', 'taxonomico.especie'),

            //Intento 3 FINAL
            Text::make('ID Taxon', 'taxonID'),

            // --- GRUPO PREVIEW ---
            Text::make('Nombre Común', 'preview.vernacularName'),
            Text::make('Nombre Científico', 'preview.scientificName'),
            //Text::make('Nombre Shuar', 'preview.shuarName'),
            Text::make('Descripción', 'preview.descripcion'),
            Text::make('Imagen URL', 'preview.imagen'),

            // --- GRUPO TAXONOMICO ---
            Text::make('ID del Taxon', 'taxonomico.taxonID'),
            Text::make('Reino', 'taxonomico.kingdom'),
            Text::make('División', 'taxonomico.phylum'),
            Text::make('Clase', 'taxonomico.class'),
            //Text::make('Subclase', 'taxonomico.subclass'),
            //Text::make('Super Orden', 'taxonomico.superOrder'),
            Text::make('Orden', 'taxonomico.order'),
            Text::make('Suborden', 'taxonomico.suborder'),
            Text::make('Familia', 'taxonomico.family'),
            Text::make('Género', 'taxonomico.genus'),
            Text::make('Especie', 'taxonomico.especie'),
        ];
    }
}