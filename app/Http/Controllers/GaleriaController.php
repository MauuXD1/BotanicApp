<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planta;
use Illuminate\Support\Facades\DB;

class GaleriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Planta::query();
        //DB::enableQueryLog();
        // Esto asegura que 'arbol' sea igual a 'árbol' y 'ARBOL'
        $query->options(['collation' => ['locale' => 'es', 'strength' => 1]]);


        // 1. Lógica de búsqueda principal (Nombre común o científico)
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;

            // CORRECCIÓN: Usamos 'preview' en minúsculas según tu JSON
            $query->where(function($q) use ($busqueda) {
                // 'options' => 'i' hace que la búsqueda sea insensible a mayúsculas/minúsculas (case-insensitive)
                $q->where('preview.vernacularName', 'like', $busqueda . '%')
                  //->options(['collation' => ['locale' => 'es', 'strength' => 1]])//ESTA PARTE ES POR QUE EL índice está ordenado bajo reglas del idioma español: { "PREVIEW.vernacularName": 1 }, { collation: { locale: "es", strength: 1 } }
                  ->orWhere('preview.scientificName', 'like', $busqueda . '%');
            });
        }


        // 2. Lógica de búsqueda por Familia (Campo que tienes en tu Blade)
        if ($request->filled('family')) {
            // Según tu JSON, la familia está dentro del objeto 'taxonomico'
            $query->where('taxonomico.family', 'like', '%' . $request->family . '%');
        }

        // =================================================================
        // 🛑 ZONA DE DEBUG DE MÉTRICAS (Actualizada a PREVIEW)
        // =================================================================
        if ($request->filled('buscar')) {
             $busqueda = $request->buscar;
             
             // Comando manual para ver estadísticas reales
             // NOTA: Aquí también cambiamos a 'PREVIEW' para el debug
             $comando = [
                'explain' => [
                    'find' => 'plantas', 
                    'filter' => [
                        '$or' => [
                            ['preview.vernacularName' => ['$regex' => '^' . $busqueda, '$options' => 'i']],
                            ['preview.scientificName' => ['$regex' => '^' . $busqueda, '$options' => 'i']]
                            //['taxonomico.family' => ['$regex' => '^' . $busqueda, '$options' => 'i']]
                            
                        ]
                    ],
                    'collation' => ['locale' => 'es', 'strength' => 1]
                ],
                'verbosity' => 'executionStats' 
             ];

             try {
                 $resultado = DB::connection('mongodb')->getDatabase()->command($comando);
                 $stats = $resultado->toArray()[0];
                 
                 dd([
                    'RESULTADO' => 'Debug Exitoso',
                    'BUSQUEDA' => $busqueda,
                    'DEVUELTOS (nReturned)' => $stats->executionStats->nReturned,
                    'ESCANEADOS (totalDocsExamined)' => $stats->executionStats->totalDocsExamined,
                    'TIEMPO (ms)' => $stats->executionStats->executionTimeMillis,
                    'PLAN GANADOR' => $stats->queryPlanner->winningPlan->stage ?? 'N/A' // Esperamos IXSCAN
                 ]);
                 
             } catch (\Exception $e) {
                 dd("Error en debug: " . $e->getMessage());
             }
        }
        // =================================================================
        // =================================================================
        // =================================================================



        // 3. Proyección de datos
        // Seleccionamos taxonID y preview. 
        // Si necesitas mostrar la familia en la tarjeta, agrega 'taxonomico' => 1 aquí.
        $items = $query->project([
            'taxonID' => 1,
            'preview' => 1
        ])->paginate(12);//->get();

        //dd(DB::getQueryLog());
        return view('inicio', compact('items'));
    }

    public function show($id){
        $planta = Planta::where('taxonID', $id)->first();
        
        if (!$planta) {
            abort(404, 'Planta no encontrada');
        }

        return view('detalle', compact('planta'));
    }
}