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

            // En MongoDB usamos "punto" para entrar a los objetos anidados.
            // Aquí buscamos coincidencia en el Nombre Común O en el Nombre Científico.
            $query->where(function($q) use ($busqueda) {
                $q->where('PREVIEW.vernacularName', 'like', '%' . $busqueda . '%')
                  ->orWhere('PREVIEW.scientificName', 'like', '%' . $busqueda . '%');
            });
        }

        // OPTIMIZACIÓN:
        // Como es una galería, no necesitas cargar los arrays pesados de FITOQUIMICO 
        // o FISICOQUIMICO. Usamos 'project' (o select) para traer solo lo visual.
        $items = $query->project([
            'plantaID' => 1,
            'PREVIEW' => 1
        ])->get();

        return view('inicio', compact('items'));
    }
}