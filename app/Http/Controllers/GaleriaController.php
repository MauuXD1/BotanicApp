<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planta;

class GaleriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Planta::query();

        // 1. Lógica de búsqueda principal (Nombre común o científico)
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;

            // CORRECCIÓN: Usamos 'preview' en minúsculas según tu JSON
            $query->where(function($q) use ($busqueda) {
                // 'options' => 'i' hace que la búsqueda sea insensible a mayúsculas/minúsculas (case-insensitive)
                $q->where('preview.vernacularName', 'like', $busqueda . '%')
                  ->options(['collation' => ['locale' => 'es', 'strength' => 1]])//ESTA PARTE ES POR QUE EL índice está ordenado bajo reglas del idioma español: { "PREVIEW.vernacularName": 1 }, { collation: { locale: "es", strength: 1 } }
                  ->orWhere('preview.scientificName', 'like', $busqueda . '%');
            });
        }

        // 2. Lógica de búsqueda por Familia (Campo que tienes en tu Blade)
        if ($request->filled('family')) {
            // Según tu JSON, la familia está dentro del objeto 'taxonomico'
            $query->where('taxonomico.family', 'like', '%' . $request->family . '%');
        }

        // 3. Proyección de datos
        // Seleccionamos taxonID y preview. 
        // Si necesitas mostrar la familia en la tarjeta, agrega 'taxonomico' => 1 aquí.
        $items = $query->project([
            'taxonID' => 1,
            'preview' => 1
        ])->paginate(12);//->get();

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