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
use MoonShine\Fields\KeyValue;
use MoonShine\Fields\FieldsGroup;
use MoonShine\Decorations\Collapse;

// IMPORTANTE: Importar HasOne y el Recurso nuevo
use MoonShine\Laravel\Fields\Relationships\HasOne; // ✅ Correcto
use App\MoonShine\Resources\Georeferencia\GeoreferenciaResource;
use MoonShine\UI\Fields\Preview; // ✅ Este es el correcto
use MoonShine\UI\Fields\Hidden;


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
                ID::make(),
                Text::make('ID del taxon', 'taxonID')->required(),
            ]),

            // ============================================================
            // NUEVA SECCIÓN: MAPA Y GEOREFERENCIACIÓN
            // ============================================================
            Box::make('Ubicación Geográfica', [
                
                // Mapa (Igual que antes)
                Preview::make('Mapa Interactivo. Mueve el marcador para capturar las coordenadas.')
                    ->fill(view('admin.components.map-picker', [
                        'uniqueId' => uniqid(),
                        'lat' => $this->getResource()->getItem()?->georeferencia?->decimalLatitude,
                        'lng' => $this->getResource()->getItem()?->georeferencia?->decimalLongitude,
                    ])),

                // Inputs (Simplificados y Limpios)
                Grid::make([
                    Column::make([
                        // Solo necesitamos el name 'lat_temp'
                        Text::make('Latitud', 'lat_temp')
                            ->required(),
                    ])->columnSpan(6),

                    Column::make([
                        // Solo necesitamos el name 'lng_temp'
                        Text::make('Longitud', 'lng_temp')
                            ->required(),
                    ])->columnSpan(6),
                ]),
            ]),
            // ============================================================

            // --- PREVIEW ---
            Grid::make([
                Column::make([
                    Box::make('Datos Visuales (Preview)', [
                        Json::make('Preview', 'preview')
                            ->fields([
                                Text::make('ID del Taxon', 'taxonID'),
                                Text::make('Nombre Común', 'vernacularName'),
                                Text::make('Nombre Científico', 'scientificName'),
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
                                Text::make('Orden', 'order'),
                                Text::make('Familia', 'family'),
                                Text::make('Género', 'genus'),
                                Text::make('Especie', 'especie'),
                                Json::make('Otros Atributos', 'atributos_extra')
                                    ->keyValue('Atributo', 'Valor')
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
                Json::make('Propiedades Fisicoquímicas', 'fisicoquimico')
                    ->fields([
                        Text::make('Parámetro', 'measurementType')->hint('Ej: pH, Humedad'),
                        Text::make('Valor', 'measurementValue'),
                        Text::make('Unidad', 'measurementUnit')->hint('Ej: %, mg/g'),
                        Text::make('Referencia / Norma', 'measurementMethod'),
                    ])
                    ->removable(),
            ]),
        ];
    }
}