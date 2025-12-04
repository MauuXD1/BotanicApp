<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Planta extends Model
{
    use HasFactory;

    // protected $connection = 'mongodb'; // Descomentar si no es la conexión por defecto
    
    /**
     * Define el nombre de la colección en MongoDB (opcional, pero recomendado)
     */
    protected $collection = 'plantas';

    /**
     * Los atributos que se pueden asignar masivamente.
     * Deben coincidir con las claves raíz de tu JSON Schema.
     */
    protected $fillable = [
        'plantaID',       // Clave primaria única del negocio
        'PREVIEW',        // Objeto con datos visuales y nombre común
        'TAXONOMICO',     // Objeto con la clasificación biológica
        'FITOQUIMICO',    // Array de objetos (mediciones)
        'FISICOQUIMICO'   // Array de objetos (mediciones)
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
}