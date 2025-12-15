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
//use MoonShine\UI\Fields\KeyValue;
use MoonShine\Fields\KeyValue;
use MoonShine\Fields\FieldsGroup;
use MoonShine\Decorations\Collapse;

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
                
                // Atributo corregido: 'plantaID'
                Text::make('ID del taxon', 'taxonID')
                ->required()
                    //->hint('Identificador único para la planta'),
            ]),

            // --- PREVIEW ---
            Grid::make([
                Column::make([
                    Box::make('Datos Visuales (Preview)', [
                        // Atributo corregido: 'preview'
                        Json::make('Preview', 'preview')
                            ->fields([
                                Text::make('ID del Taxon', 'taxonID'),
                                Text::make('Nombre Común', 'vernacularName'),
                                Text::make('Nombre Científico', 'scientificName'),
                                // Text::make('Nombre Shuar', 'shuarName'),
                                // Si guardas la URL de la imagen:
                                Image::make('Imagen', 'imagen')
                                    ->disk('public') 
                                    ->dir('plantas'),
                                Text::make('Descripción Corta', 'descripcion'),
                            ])
                            ->vertical()
                            ->object()
                            ->removable(),
                    ])
                ])->columnSpan(6),

                // --- TAXONOMÍA ---
                Column::make([
                    Box::make('Información Taxonómica', [
                        Json::make('Taxonomía', 'taxonomico')
                            ->fields([
                                Text::make('ID del Taxon', 'taxonID'),
                                Text::make('Reino', 'kingdom')->default('Plantae'),
                                Text::make('División', 'phylum'),
                                Text::make('Clase', 'class'),
                                // Text::make('Subclase', 'subclass'),
                                // Text::make('Super Orden', 'superOrder'),
                                Text::make('Orden', 'order'),
                                // Text::make('Suborden', 'suborder'),
                                Text::make('Familia', 'family'),
                                Text::make('Género', 'genus'),
                                Text::make('Especie', 'especie'),

                                // 2. CAMPOS DINÁMICOS (Aquí se agregaría campos como Subclase, Super Orden, etc. a demanda)
                                Json::make('Otros Atributos', 'atributos_extra') // Guardará en taxonomico.atributos_extra
                                    ->keyValue(
                                        key: 'Atributo (Ej: Subclase)', // Etiqueta para la clave
                                        value: 'Valor'                 // Etiqueta para el valor
                                    )
                                    ->removable(),
                            ])
                            ->vertical()
                            ->object()
                            ->removable(),
                    ])
                ])->columnSpan(6),
            ]),
            
            // --- DATOS DE ANALISIS CIENTÍFICOS ---
            
            Box::make('Análisis Fitoquímico', [
                // Atributo corregido: 'fitoquimico'
                Json::make('Compuestos Fitoquímicos', 'fitoquimico')
                    ->fields([
                        Text::make('Nombre del Compuesto', 'measurementType'),
                        Text::make('Tipo de Metabolito', 'measurementValue'),                        
                        Text::make('Método de Extracción', 'measurementMethod'),
                        Text::make('Concentración', 'measurementRemarks'),
                    ])
                    ->removable(),
            ]),

            Box::make('Análisis Fisicoquímico', [
                // Atributo corregido: 'fisicoquimicos'
                Json::make('Propiedades Fisicoquímicas', 'fisicoquimicos')
                    ->fields([
                        Text::make('Parámetro', 'measurementType')
                            ->hint('Ej: pH, Humedad, Cenizas'),
                        Text::make('Valor', 'measurementValue'),
                        Text::make('Unidad', 'measurementUnit')
                            ->hint('Ej: %, mg/g'),
                        Text::make('Referencia / Norma', 'measurementMethod'),
                    ])
                    ->removable(),
            ]),
        ];
    }
}