<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $connection = 'mongodb'; // Especifica la conexión MongoDB

    public function up(): void
    {
        Schema::connection($this->connection)->create('plantas', function (Blueprint $collection) {
            // MongoDB crea el _id automáticamente
            // Índice único para taxonID
            $collection->unique('taxonID');
            
            // // Índices para campos de búsqueda común
            // $collection->index('PREVIEW');
            // $collection->index('TAXONOMICO');
            // $collection->index('FITOQUIMICO');
            // $collection->index('FISICOQUIMICO');
        });

        // Crear índices adicionales usando MongoDB directamente
        $collection = DB::connection('mongodb')->getMongoDB()->selectCollection('plantas');

        // Índice único entre documentos (ya creado arriba, pero confirmando)
        // $collection->createIndex(['taxonID' => 1], ['unique' => true]);

        // Índices para búsquedas frecuentes en preview
        $collection->createIndex([
            'preview.vernacularName' => 'text',
            'preview.scientificName' => 'text'
        ], ['name' => 'idx_busqueda_texto_preview']);

        // Índices para búsquedas frecuentes en TAXONOMICO
        $collection->createIndex(['taxonomico.vernacularName' => 1], [
            'name' => 'idx_taxonomico_vernacularName',
            'collation' => ['locale' => 'es', 'strength' => 1]
        ]);

        $collection->createIndex(['taxonomico.scientificName' => 1], ['name' => 'idx_taxonomico_scientificName']);

        // ÍNDICES COMPUESTOS PARA BÚSQUEDAS COMBINADAS
        // Para Búsquedas Taxonómicas Jerárquicas
        $collection->createIndex([
            'taxonomico.family' => 1,
            'taxonomico.genus' => 1
        ], ['name' => 'idx_taxonomico_BTJ']);

        // Índice para Búsquedas por Clasificación Biológica
        $collection->createIndex([
            'taxonomico.kingdom' => 1,
            'taxonomico.phylum' => 1,
            'taxonomico.class' => 1,
            'taxonomico.order' => 1
        ], ['name' => 'idx_taxonomico_BCB']);

        // Índice para búsquedas por método FITOQUIMICO
        $collection->createIndex(['fitoquimico.measurementMethod' => 1], [
            'name' => 'idx_fitoquimico_method',
            'sparse' => true
        ]);

        // Índice compuesto para consultas combinadas fitoquimico
        $collection->createIndex([
            'fitoquimico.measurementType' => 1,
            'fitoquimico.measurementValue' => 1
        ], ['name' => 'idx_fitoquimico_type_value']);

        // Índice para búsquedas por método FISICOQUIMICO
        $collection->createIndex(['fisicoquimico.measurementMethod' => 1], [
            'name' => 'idx_fisicoquimico_method',
            'sparse' => true
        ]);

        // Índice compuesto para consultas combinadas FISICOQUIMICO
        $collection->createIndex([
            'fisicoquimico.measurementType' => 1,
            'fisicoquimico.measurementValue' => 1
        ], ['name' => 'idx_fisicoquimico_type_value']);
    }

    public function down(): void
    {
        Schema::connection($this->connection)->drop('plantas');
    }
};
