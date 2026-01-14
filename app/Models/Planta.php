<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

use App\Models\Georeferencia;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Planta extends Model
{
    use HasFactory;
    
    /**
     * Define el nombre de la colección en MongoDB (opcional, pero recomendado)
     */
    protected $collection = 'plantas';
    protected $connection = 'mongodb';

    /**
     * Los atributos que se pueden asignar masivamente.
     * Deben coincidir con las claves raíz de tu JSON Schema.
     */
    protected $fillable = [
        'taxonID',       
        'PREVIEW',        
        'TAXONOMICO',     
        'FITOQUIMICO',    
        'FISICOQUIMICO',   
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * Esto ayuda a Laravel a entender que estos campos son objetos/arrays JSON.
     */
    protected $casts = [
        'PREVIEW' => 'array',
        'TAXONOMICO' => 'array',
        'FITOQUIMICO' => 'array',
        'FISICOQUIMICO' => 'array',
    ];
    
    
    // Relación
    public function georeferencia()
    {
        // Asegúrate de que los keys coincidan con tus datos
        return $this->hasOne(Georeferencia::class, 'taxonID', 'taxonID');
    }

    /**
     * (Eventos del Modelo) no tuve opccion xD
     */
    protected static function booted()
    {
        // EVENTO 1: "saving" (Se ejecuta ANTES de guardar en MongDB)
        // Aquí limpiamos los datos georeferenciales para que NO entre a la colección 'plantas'
        // porque ingresa en el mismo formulario pero aqui van a la otra colección
        static::saving(function ($planta) {
            // Borramos explícitamente los campos temporales del array de atributos
            unset($planta->attributes['lat_temp']);
            unset($planta->attributes['lng_temp']);
        });

        // EVENTO 2: "saved" (Se ejecuta DESPUÉS de que la planta ya se guardó)
        // Aquí creamos la georeferencia porque ya tenemos la planta segura
        static::saved(function ($planta) {
            
            // 1. Capturamos lo que venía en el formulario
            $lat = request()->input('lat_temp');
            $lng = request()->input('lng_temp');

            // 2. Solo si hay coordenadas válidas actuamos
            if ($lat && $lng) {
                
                // Obtenemos el nombre común desde el campo preview (si existe)
                $nombreComun = $planta->preview['vernacularName'] ?? 'Planta sin nombre común';

                // 3. Guardamos en la OTRA colección (Georeferencia)
                Georeferencia::updateOrCreate(
                    ['taxonID' => $planta->taxonID], // Buscamos por el ID del taxón
                    [
                        // Generamos ID de ubicación solo si es nuevo (el updateOrCreate lo maneja)
                        'locationID'       => 'LOC-' . uniqid(), 
                        'vernacularName'   => $nombreComun,
                        'decimalLatitude'  => (float) $lat,
                        'decimalLongitude' => (float) $lng,
                        'geodeticDatum'    => 'WGS84',
                        
                        // IMPORTANTE: Geometría para GeoJSON
                        'geometry' => [
                            'type' => 'Point',
                            'coordinates' => [
                                (float) $lng, // Mongo pide Longitud primero
                                (float) $lat  // Luego Latitud
                            ]
                        ]
                    ]
                );
            }
        });
    }
}