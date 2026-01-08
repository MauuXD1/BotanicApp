<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Georeferencia extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'georeferenciaciones';

    protected $fillable = [
        'locationID', 'taxonID', 'vernacularName',
        'decimalLatitude', 'decimalLongitude', 'geodeticDatum', 'geometry'
    ];
}
