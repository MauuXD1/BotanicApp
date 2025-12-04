<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Planta\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use App\MoonShine\Resources\Planta\PlantaResource;

/**
 * @extends FormPage<PlantaResource>
 */
class PlantaFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            
            // --- SECCIÓN GENERAL ---
            Box::make('Información General', [
                ID::make(), // ID interno de Mongo
                
                Text::make('ID de Planta (Negocio)', 'plantaID')
                    ->required()
                    ->hint('Identificador único para la planta'),
            ]),

            // --- PREVIEW Y TAXONOMÍA (GRID 2 COLUMNAS) ---
            Grid::make([
                Column::make([
                    Box::make('Datos Visuales (Preview)', [
                        // Usamos Json field. Aunque PREVIEW sea un objeto único, 
                        // el campo Json lo maneja como estructura flexible.
                        Json::make('Preview', 'PREVIEW')
                            ->fields([
                                Text::make('Nombre Común', 'nombre_comun'),
                                Text::make('Nombre Científico', 'nombre_cientifico'),
                                // Si guardas la URL de la imagen:
                                Image::make('Imagen', 'imagen')
                                    ->disk('public') // Asegúrate de tener el link simbólico
                                    ->dir('plantas'),
                                Text::make('Descripción Corta', 'descripcion'),
                            ])
                            ->vertical() // Alineación vertical de los campos internos
                            ->removable()
                    ])
                ])->columnSpan(6),

                Column::make([
                    Box::make('Información Taxonómica', [
                        Json::make('Taxonomía', 'TAXONOMICO')
                            ->fields([
                                Text::make('Reino', 'reino')->default('Plantae'),
                                Text::make('División', 'division'),
                                Text::make('Clase', 'clase'),
                                Text::make('Orden', 'orden'),
                                Text::make('Familia', 'familia'),
                                Text::make('Género', 'genero'),
                                Text::make('Especie', 'especie'),
                            ])
                            ->vertical()
                            ->removable()
                    ])
                ])->columnSpan(6),
            ]),

            // --- DATOS CIENTÍFICOS (ARRAYS DE OBJETOS) ---
            
            Box::make('Análisis Fitoquímico', [
                // Este es ideal para "Array de objetos"
                Json::make('Compuestos Fitoquímicos', 'FITOQUIMICO')
                    ->fields([
                        Text::make('Nombre del Compuesto', 'compuesto'),
                        Text::make('Tipo de Metabolito', 'tipo'), // Ej: Alcaloide, Flavonoide
                        Text::make('Concentración', 'concentracion'),
                        Text::make('Método de Extracción', 'metodo'),
                    ])
                    ->removable() // Permite eliminar filas
                    //->fullWidth() // Ocupa todo el ancho
            ]),

            Box::make('Análisis Fisicoquímico', [
                Json::make('Propiedades Fisicoquímicas', 'FISICOQUIMICO')
                    ->fields([
                        Text::make('Parámetro', 'parametro')
                            ->hint('Ej: pH, Humedad, Cenizas'),
                        Text::make('Valor', 'valor'),
                        Text::make('Unidad', 'unidad')
                            ->hint('Ej: %, mg/g'),
                        Text::make('Referencia / Norma', 'referencia'),
                    ])
                    ->removable()
                    //->fullWidth()
            ]),
        ];
    }
}