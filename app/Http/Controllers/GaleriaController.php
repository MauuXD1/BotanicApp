<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planta;
use Illuminate\Support\Facades\DB;

class GaleriaController extends Controller
{
    public function index(Request $request)
    {
        // Iniciamos la query
        $query = Planta::query();

        // Aplicamos collation en español para que ñ, acentos, etc. se ordenen/busquen bien
        $query->options(['collation' => ['locale' => 'es', 'strength' => 1]]);

        // ------------------------------------------------------------------
        // 1. BÚSQUEDA GENERAL (Uso del Índice de Texto: idx_busqueda_texto_preview)
        // ------------------------------------------------------------------
        if ($request->filled('buscar')) {

            // Busca palabras completas o frases en los campos 'preview.vernacularName' y 'scientificName'
            $query->whereRaw(['$text' => ['$search' => $request->buscar]]);
        
        }

        // ------------------------------------------------------------------
        // 2. FILTROS TAXONÓMICOS (Indices: idx_taxonomico_BCB y idx_taxonomico_BTJ)
        // ------------------------------------------------------------------

        $taxoFields = [
            'kingdom', 'phylum', 'class', 'order', // idx_taxonomico_BCB
            'family', 'genus'                      // idx_taxonomico_BTJ
        ];

        foreach ($taxoFields as $field) {
            if ($request->filled($field)) {
                // Ejemplo: taxonomico.family LIKE 'Lamiaceae%'
                $query->where('taxonomico.' . $field, 'regex', new \MongoDB\BSON\Regex('^' . $request->$field, 'i'));
            }
        }

        // ------------------------------------------------------------------
        // 3. FILTROS FITOQUÍMICOS (Indices: idx_fitoquimico_method, idx_fitoquimico_type_value)
        // ------------------------------------------------------------------
        
        // A. Por Método (Sparse Index)
        if ($request->filled('fito_method')) {
            $query->where('fitoquimico.measurementMethod', 'regex', new \MongoDB\BSON\Regex('^' . $request->fito_method, 'i'));
        }

        // B. Por Tipo y Valor (Compound Index)
        // Usamos elemMatch para asegurar que el Tipo y el Valor estén en el MISMO objeto del array
        if ($request->filled('fito_type') || $request->filled('fito_val')) {
            $elemMatch = [];

            if ($request->filled('fito_type')) {
                $elemMatch['measurementType'] = new \MongoDB\BSON\Regex('^' . $request->fito_type, 'i');
            }
            if ($request->filled('fito_val')) {

                // Aquí intento buscar coincidencias exactas o mayores si es numérico, 
                // pero lo dejo como regex flexible para texto/número mixto.
                $elemMatch['measurementValue'] = new \MongoDB\BSON\Regex('^' . $request->fito_val, 'i');
            }

            $query->where('fitoquimico', 'elemMatch', $elemMatch);
        }

        // ------------------------------------------------------------------
        // 4. FILTROS FISICOQUÍMICOS (Misma lógica)
        // ------------------------------------------------------------------
        
        if ($request->filled('fisico_method')) {
            $query->where('fisicoquimico.measurementMethod', 'regex', new \MongoDB\BSON\Regex('^' . $request->fisico_method, 'i'));
        }

        if ($request->filled('fisico_type') || $request->filled('fisico_val')) {
            $elemMatch = [];
            if ($request->filled('fisico_type')) {
                $elemMatch['measurementType'] = new \MongoDB\BSON\Regex('^' . $request->fisico_type, 'i');
            }
            if ($request->filled('fisico_val')) {
                $elemMatch['measurementValue'] = new \MongoDB\BSON\Regex('^' . $request->fisico_val, 'i');
            }
            $query->where('fisicoquimico', 'elemMatch', $elemMatch);
        }

        // ------------------------------------------------------------------
        // 5. PROYECCIÓN Y PAGINACIÓN
        // ------------------------------------------------------------------
        // Proyectamos solo lo necesario para la tarjeta. 
        // Agregamos 'taxonomico' por si quieres mostrar familia/nombre científico extra.
        $items = $query->project([
            'taxonID' => 1,
            'preview' => 1,
            
        ])->paginate(12);

        // Añadimos los parámetros a la URL de paginación
        $items->appends($request->all());

        return view('inicio', compact('items'));
    }

    public function show($id){
        // AGREGAMOS 'with('georeferencia')' para traer la ubicación en la misma consulta
        $planta = Planta::with('georeferencia')->where('taxonID', $id)->first();
        
        if (!$planta) {
            abort(404, 'Planta no encontrada');
        }

        return view('detalle', compact('planta'));
    }
}