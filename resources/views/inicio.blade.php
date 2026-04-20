<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Plantas</title>
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Estilos adicionales para transiciones suaves --}}
    <style>
        :root {
            --verde-institucional: #1B4332;
            --verde-clorofila: #2D6A4F;
            --verde-brote: #99D98C;
            --blanco-botanico: #F8FBF8;
            --gris-carbon: #404040;
            --blanco-puro: #ffffff;

            --primary: var(--verde-clorofila);
            --primary-dark: var(--verde-institucional);
            --muted-green: var(--verde-brote);
            --bg-light: var(--blanco-botanico);
            --text-dark: var(--gris-carbon);
        }

        /* Transiciones panel filtros */
        .filters-panel {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        .filters-panel.open {
            max-height: 1000px; /* Valor alto para permitir expansión */
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen flex flex-col">

    {{-- Header (Igual que tu original) --}}
    <header class="text-white shadow-md" style="background-color: #1B4332;">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex space-x-8">
                <a href="{{ route('inicio') }}" class="text-white hover:text-green-500 transition bg-gray-800 px-4 py-2 rounded-lg text-sm">Inicio</a>
            </div>
            <div>
                @if(file_exists(public_path('logo.png')))
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10">
                @else
                    <span class="text-2xl font-bold text-green-500">BotanicApp</span>
                @endif
            </div>
            <div class="flex space-x-8">
                <a href="/admin" class="text-white hover:text-green-500 transition bg-gray-800 px-4 py-2 rounded-lg text-sm">Panel Admin</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 flex-grow">
        
        {{-- FORMULARIO DE BÚSQUEDA Y FILTROS --}}
        <form method="GET" action="{{ route('inicio') }}" class="bg-gray-100 p-6 rounded-xl shadow-sm mb-8">
            
            {{-- 1. Búsqueda General (Text Search - idx_busqueda_texto_preview) --}}
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Búsqueda General</label>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" 
                        placeholder="Nombre común o científico..." 
                        class="w-full rounded-lg border-gray-300 border px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none text-lg">
                </div>
                
                {{-- Botones de Acción Principal --}}
                <div class="flex items-end gap-2">
                    <button type="button" id="toggleFiltersBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-4 rounded-lg transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-200" id="filterIcon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filtros Avanzados
                    </button>
                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-6 rounded-lg transition shadow-md">
                        Buscar
                    </button>
                </div>
            </div>

            {{-- 2. Panel Desplegable de Filtros Avanzados --}}
            {{-- La clase 'open' se añade con JS si hay filtros activos en la URL --}}
            <div id="advancedFilters" class="filters-panel {{ request()->anyFilled(['family', 'genus', 'kingdom', 'phylum', 'class', 'order', 'fito_method', 'fito_type', 'fisico_method']) ? 'open' : '' }}">
                <div class="pt-4 border-t border-gray-300 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- SECCIÓN A: Taxonomía (Indices: idx_taxonomico_BTJ y idx_taxonomico_BCB) --}}
                    <div class="bg-green-300 p-4 rounded-lg">
                        <h3 class="font-bold text-green-900 mb-3 border-b border-green-300 pb-1">Taxonomía y Clasificación</h3>
                        <div class="grid grid-cols-2 gap-3">
                            {{-- Jerarquía Mayor --}}
                            <div class="col-span-2 grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-900">Reino</label>
                                    <input type="text" name="kingdom" value="{{ request('kingdom') }}" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-green-500 focus:border-green-500">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-900">División</label>
                                    <input type="text" name="phylum" value="{{ request('phylum') }}" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-green-500 focus:border-green-500">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-900">Clase </label>
                                <input type="text" name="class" value="{{ request('class') }}" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-900">Orden </label>
                                <input type="text" name="order" value="{{ request('order') }}" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            {{-- Jerarquía Menor (Indice BTJ) --}}
                            <div>
                                <label class="text-xs font-semibold text-gray-900">Familia</label>
                                <input type="text" name="family" value="{{ request('family') }}" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-900">Género</label>
                                <input type="text" name="genus" value="{{ request('genus') }}" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN B: Fitoquímica (Indices: idx_fitoquimico_method, idx_fitoquimico_type_value) --}}
                    <div class="bg-blue-300 p-4 rounded-lg">
                        <h3 class="font-bold text-blue-900 mb-3 border-b border-blue-300 pb-1">Análisis Fitoquímico</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs font-semibold text-gray-900">Método de Medición</label>
                                <input type="text" name="fito_method" value="{{ request('fito_method') }}" placeholder="Ej: HPLC" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-900">Tipo de Medición</label>
                                    <input type="text" name="fito_type" value="{{ request('fito_type') }}" placeholder="Ej: Flavonoids" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-900">Valor cualitativo</label>
                                    <input type="text" name="fito_val" value="{{ request('fito_val') }}" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN C: Fisicoquímica (Indices: idx_fisicoquimico_method, idx_fisicoquimico_type_value) --}}
                    <div class="bg-purple-300 p-4 rounded-lg">
                        <h3 class="font-bold text-purple-800 mb-3 border-b border-purple-300 pb-1">Análisis Fisicoquímico</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs font-semibold text-gray-900">Método de medición</label>
                                <input type="text" name="fisico_method" value="{{ request('fisico_method') }}" placeholder="Ej: pH Meter" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-900">Tipo de medición</label>
                                    <input type="text" name="fisico_type" value="{{ request('fisico_type') }}" placeholder="Ej: Acidez" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-900">Valor de medición</label>
                                    <input type="text" name="fisico_val" value="{{ request('fisico_val') }}" class="w-full text-sm border-gray-300 rounded p-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                {{-- Botón de Limpiar (Solo aparece si hay algún filtro) --}}
                @if(request()->anyFilled(['buscar', 'kingdom', 'phylum', 'class', 'order', 'family', 'genus', 'fito_method', 'fito_type', 'fito_val', 'fisico_method', 'fisico_type', 'fisico_val']))
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('inicio') }}" class="text-sm text-red-500 hover:text-red-700 font-medium hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Limpiar todos los filtros
                        </a>
                    </div>
                @endif
            </div>
        </form>

        
        {{-- Galería --}}
        @if($items->isEmpty())
             {{-- ... Cuando No se ha encontrado datos ... --}}
             <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl shadow-sm">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-gray-500 text-xl font-medium">No se encontraron plantas con estos criterios.</p>
                <a href="{{ route('inicio') }}" class="mt-4 text-green-600 hover:underline">Ver todas</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($items as $item)
                    @php
                        $data = $item->preview ?? [];
                        $nombreComun = $data['vernacularName'] ?? 'Nombre Desconocido';
                        $nombreCientifico = $data['scientificName'] ?? '';
                        
                        // 1. Obtener la ruta y limpiar posibles espacios en blanco
                        $rutaImagen = isset($data['imagen']) ? trim($data['imagen']) : null;
                        
                        // 2. Definir imagen por defecto
                        $imagenUrl = asset('/' . "PlantaIcono.png"); 

                        if ($rutaImagen && strtoupper($rutaImagen) !== 'N/A') {
                            // 3. Comprobar si es una URL válida (http o https)
                            if (str_starts_with($rutaImagen, 'http://') || str_starts_with($rutaImagen, 'https://')) {
                                $imagenUrl = $rutaImagen;
                            } 
                            // 4. Si no es URL, asumimos que es un archivo local en storage
                            else {
                                $imagenUrl = asset('storage/' . $rutaImagen);
                            }
                        }
                    @endphp

                    <div class="rounded-xl shadow hover:shadow-lg hover:scale-105 transform transition duration-300 p-3 flex flex-col h-full" style="background-color: #ffffff;">
                        <div class="relative overflow-hidden rounded-lg h-48 bg-gray-100">
                            <img src="{{ $imagenUrl }}" alt="{{ $nombreComun }}" class="w-full h-full object-cover">
                        </div>
                        <div class="mt-4 text-center flex-grow">
                            <h6 class="font-bold text-gray-800 text-xl leading-tight">{{ $nombreComun }}</h6>
                            @if($nombreCientifico)
                                <p class="text-sm text-gray-600 italic mt-1 font-medium">{{ $nombreCientifico }}</p>
                            @endif
                        </div>
                        <div class="mt-4 pt-4">
                            <a href="{{ route('planta.detalle', ['id' => $item->taxonID]) }}" 
                            class="block w-full py-2 bg-green-900 text-gray-200 text-sm font-semibold rounded-lg text-center hover:bg-green-700 hover:text-gray-900 transition-colors">
                                Ver Ficha
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        <div class="mt-8">
            {{ $items->appends(request()->query())->links() }}
        </div>

    </main>
    
    <!-- <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} BotanicApp. Todos los derechos reservados.
        </div>
    </footer> -->

    {{-- Script simple para manejar el despliegue del menú --}}
    <script>
        document.getElementById('toggleFiltersBtn').addEventListener('click', function() {
            const panel = document.getElementById('advancedFilters');
            panel.classList.toggle('open');
            
            // Opcional: Rotar icono o cambiar color botón si está activo
            this.classList.toggle('bg-gray-400');
        });
    </script>
</body>
</html>