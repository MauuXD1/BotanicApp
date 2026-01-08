<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mongodb'; // Asegúrate de que coincida con tu config/database.php

    public function up(): void
    {
        Schema::connection($this->connection)->create('georeferenciaciones', function (Blueprint $collection) {
            // MongoDB crea el _id automáticamente, pero podemos indexar tus IDs personalizados
            $collection->unique('locationID');
            $collection->index('taxonID');
            
            // Índice Geoespacial 2dsphere para el campo geometry
            // Esto es vital para hacer consultas de "plantas cercanas" en el futuro
            $collection->geospatial('geometry', '2dsphere');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->drop('georeferenciaciones');
    }
};
