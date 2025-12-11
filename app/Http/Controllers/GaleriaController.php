<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planta;

class GaleriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Planta::query();

        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;

            // IMPORTANTE: Usamos 'PREVIEW' en mayúsculas porque así está en la BD
            $query->where(function($q) use ($busqueda) {
                $q->where('PREVIEW.vernacularName', 'like', '%' . $busqueda . '%')
                  ->orWhere('PREVIEW.scientificName', 'like', '%' . $busqueda . '%');
            });
        }

        // Proyectamos solo lo necesario.
        // Nota: Asegúrate de que 'PREVIEW' esté en mayúsculas.
        $items = $query->project([
            'taxonID' => 1,
            'preview' => 1 
        ])->get();

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