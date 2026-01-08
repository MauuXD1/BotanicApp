<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $planta->preview['vernacularName'] ?? 'Detalle de Planta' }} - BotanicApp</title>
    
    {{-- TailwindCSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- NUEVO: Leaflet CSS y JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        /* Estilos para el mapa */
        #map-detail { height: 100%; width: 100%; z-index: 1; }
    </style>
</head>
<body class="bg-gray-400 text-gray-800 font-sans">

    {{-- HEADER (Igual que antes) --}}
    <header class="bg-gray-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex space-x-8">
                <a href="{{ route('inicio') }}" class="hover:text-green-400 transition font-medium">Inicio</a>
            </div>
            <div>
                @if(file_exists(public_path('logo.webp')))
                    <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-10">
                @else
                    <span class="text-xl font-bold text-green-500 tracking-wider">BotanicApp</span>
                @endif
            </div>
            <div class="flex space-x-8">
                <a href="/admin" class="px-4 py-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition text-sm">Panel Admin</a>
            </div>
        </div>
    </header>

    {{-- PREPARACIÓN DE DATOS --}}
    @php
        $preview    = $planta->preview ?? [];
        $tax        = $planta->taxonomico ?? [];
        $fito       = $planta->fitoquimico ?? [];
        $fisico     = $planta->fisicoquimico ?? [];

        $nombreComun = $preview['vernacularName'] ?? 'Sin Nombre Común';
        $nombreCientifico = $preview['scientificName'] ?? 'Sin Nombre Científico';
        $descripcion = $preview['descripcion'] ?? 'No hay descripción disponible.';

        $rutaImagen = $preview['imagen'] ?? $preview['associatedMedia'][0] ?? null;
        if ($rutaImagen) {
            $imagenUrl = str_starts_with($rutaImagen, 'http') ? $rutaImagen : asset('storage/' . $rutaImagen);
        } else {
            $imagenUrl = asset('/' . "PlantaIcono.png");
        }

        // NUEVO: Recuperar coordenadas de la relación
        // Gracias al 'with' en el controlador, esto ya está cargado
        $geo = $planta->georeferencia ?? null;
        $lat = $geo ? $geo->decimalLatitude : null;
        $lng = $geo ? $geo->decimalLongitude : null;
    @endphp

    <main class="max-w-7xl mx-auto px-6 py-10">

        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-sm text-gray-900">
            <a href="{{ route('inicio') }}" class="hover:text-green-900 flex items-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al catálogo
            </a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-semibold">{{ $nombreComun }}</span>
        </nav>

        {{-- SECCIÓN HERO (Igual que antes) --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-10 border border-gray-100">
            <div class="md:flex h-auto lg:h-[500px]">
                <div class="md:w-1/2 relative bg-gray-200 h-80 md:h-full group">
                    <img src="{{ $imagenUrl }}" alt="{{ $nombreComun }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute top-4 left-4 bg-black/60 text-white px-3 py-1 rounded-full text-xs font-mono backdrop-blur-sm">
                        ID: {{ $planta->taxonID }}
                    </div>
                </div>
                <div class="p-8 md:w-1/2 flex flex-col bg-white">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-white bg-gray-900 rounded-sm">Ficha Botánica</span>
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-1">{{ $nombreComun }}</h1>
                    <h2 class="text-2xl text-green-700 italic font-serif mb-6 pb-4 border-b border-gray-100 inline-block w-full">{{ $nombreCientifico }}</h2>
                    <div class="prose prose-sm prose-green text-gray-600 leading-relaxed mb-8 overflow-y-auto max-h-40 pr-2">
                        <p>{{ $descripcion }}</p>
                    </div>
                    <div class="mt-auto pt-6 border-t border-gray-100 w-full">
                        <div class="grid grid-cols-2 gap-6">
                            @if(!empty($tax['family']))
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Familia</span>
                                    <span class="text-lg font-serif text-gray-800 italic border-l-2 border-green-500 pl-3">{{ $tax['family'] }}</span>
                                </div>
                            @endif
                            @if(!empty($tax['kingdom']))
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Reino</span>
                                    <span class="text-lg font-serif text-gray-800 italic border-l-2 border-purple-500 pl-3">{{ $tax['kingdom'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- COLUMNA IZQUIERDA --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- Tabla Taxonómica --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-gray-800 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Taxonomía
                        </h3>
                    </div>
                    <div class="p-0">
                        @if(!empty($tax))
                            <table class="w-full text-sm text-left">
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($tax as $key => $val)
                                        @if(is_array($val))
                                            @foreach($val as $subKey => $subVal)
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="py-3 px-6 font-medium text-gray-500 capitalize bg-gray-50 w-1/3">{{ $subKey }}</td>
                                                    <td class="py-3 px-6 text-gray-800 font-semibold italic">{{ $subVal }}</td>
                                                </tr>
                                            @endforeach
                                        @elseif(is_string($val) || is_numeric($val))
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="py-3 px-6 font-medium text-gray-500 capitalize bg-gray-50 w-1/3">{{ $key }}</td>
                                                <td class="py-3 px-6 text-gray-800 font-semibold italic">{{ $val }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-6 text-center text-gray-400 italic">No hay datos taxonómicos.</div>
                        @endif
                    </div>
                </div>

                {{-- ================================================= --}}
                {{-- NUEVO: MAPA DE UBICACIÓN REAL --}}
                {{-- ================================================= --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-gray-800 px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Ubicación Geográfica
                        </h3>
                    </div>
                    
                    {{-- Contenedor del Mapa --}}
                    <div class="h-80 bg-gray-100 relative">
                        @if($lat && $lng)
                            <div id="map-detail"></div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                <span class="text-sm font-medium">Ubicación no registrada</span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- COLUMNA DERECHA --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- ================================================= --}}
                {{-- NUEVO: TABLA FITOQUÍMICA (LIMITADA A 8) --}}
                {{-- ================================================= --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-green-50 to-white">
                        <h3 class="text-xl font-bold text-gray-800 text-green-700">Análisis Fitoquímico</h3>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">{{ count($fito) }} Registros</span>
                    </div>
                    <div class="overflow-x-auto">
                        @if(count($fito) > 0)
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-500 font-semibold uppercase tracking-wider">
                                    <tr>
                                        <th class="py-4 px-6">Compuesto</th>
                                        <th class="py-4 px-6">Valor / Conc.</th>
                                        <th class="py-4 px-6">Método</th>
                                        <th class="py-4 px-6">Notas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100" id="table-fito-body">
                                    @foreach($fito as $item)
                                        {{-- Lógica de ocultar: Si el índice >= 8, agregamos la clase 'hidden' --}}
                                        <tr class="hover:bg-gray-50 transition fito-row {{ $loop->index >= 8 ? 'hidden' : '' }}">
                                            <td class="py-4 px-6 font-bold text-gray-800">{{ $item['measurementType'] ?? 'N/A' }}</td>
                                            <td class="py-4 px-6 text-green-600 font-bold font-mono">{{ $item['measurementValue'] ?? '--' }}</td>
                                            <td class="py-4 px-6 text-gray-600">{{ $item['measurementMethod'] ?? '-' }}</td>
                                            <td class="py-4 px-6 text-gray-500 italic text-xs">{{ $item['measurementRemarks'] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            {{-- Botón Ver Más --}}
                            @if(count($fito) > 8)
                                <div class="bg-gray-50 p-3 text-center border-t border-gray-100">
                                    <button onclick="toggleTable('fito')" id="btn-fito" class="text-green-600 font-bold hover:text-green-800 text-sm flex items-center justify-center w-full focus:outline-none">
                                        <span>Ver todos los compuestos</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="p-8 text-center text-gray-400">No hay información fitoquímica registrada.</div>
                        @endif
                    </div>
                </div>

                {{-- ================================================= --}}
                {{-- NUEVO: TABLA FISICOQUÍMICA (LIMITADA A 8) --}}
                {{-- ================================================= --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-blue-50 to-white">
                        <h3 class="text-xl font-bold text-gray-800 text-blue-700">Análisis Fisicoquímico</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">{{ count($fisico) }} Registros</span>
                    </div>
                    <div class="overflow-x-auto">
                        @if(count($fisico) > 0)
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-500 font-semibold uppercase tracking-wider">
                                    <tr>
                                        <th class="py-4 px-6">Parámetro</th>
                                        <th class="py-4 px-6">Valor</th>
                                        <th class="py-4 px-6">Unidad</th>
                                        <th class="py-4 px-6">Referencia</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100" id="table-fisico-body">
                                    @foreach($fisico as $item)
                                        <tr class="hover:bg-gray-50 transition fisico-row {{ $loop->index >= 8 ? 'hidden' : '' }}">
                                            <td class="py-4 px-6 font-bold text-gray-800">{{ $item['measurementType'] ?? 'N/A' }}</td>
                                            <td class="py-4 px-6 text-blue-600 font-bold font-mono">{{ $item['measurementValue'] ?? '--' }}</td>
                                            <td class="py-4 px-6 text-gray-600">{{ $item['measurementUnit'] ?? '-' }}</td>
                                            <td class="py-4 px-6 text-gray-500">{{ $item['measurementMethod'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                             {{-- Botón Ver Más --}}
                             @if(count($fisico) > 8)
                                <div class="bg-gray-50 p-3 text-center border-t border-gray-100">
                                    <button onclick="toggleTable('fisico')" id="btn-fisico" class="text-blue-600 font-bold hover:text-blue-800 text-sm flex items-center justify-center w-full focus:outline-none">
                                        <span>Ver todos los parámetros</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="p-8 text-center text-gray-400">No hay información fisicoquímica registrada.</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} BotanicApp. Ciencia y naturaleza.</p>
        </div>
    </footer>

    {{-- SCRIPTS FINALES --}}
    <script>
        // --- 1. SCRIPT DEL MAPA ---
        document.addEventListener("DOMContentLoaded", function() {
            // Solo iniciamos el mapa si existen coordenadas
            var lat = {{ $lat ?? 'null' }};
            var lng = {{ $lng ?? 'null' }};

            if (lat && lng) {
                var map = L.map('map-detail').setView([lat, lng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                // Marcador con Popup
                L.marker([lat, lng]).addTo(map)
                    .bindPopup("<b>{{ $nombreComun }}</b><br>ID: {{ $planta->taxonID }}")
                    .openPopup();
                
                // Hack para que Leaflet renderice bien las baldosas
                setTimeout(function(){ map.invalidateSize(); }, 200);
            }
        });

        // --- 2. SCRIPT DE "VER MÁS" EN TABLAS ---
        function toggleTable(type) {
            // Seleccionamos todas las filas ocultas de ese tipo (fito o fisico)
            const rows = document.querySelectorAll(`.${type}-row.hidden`);
            const btn = document.getElementById(`btn-${type}`);
            const span = btn.querySelector('span');

            if (rows.length > 0) {
                // MODO EXPANDIR: Quitamos la clase 'hidden'
                rows.forEach(row => {
                    row.classList.remove('hidden');
                    row.classList.add('expanded'); // Marca para saber que estaban ocultas
                });
                span.textContent = "Ver menos";
                btn.querySelector('svg').style.transform = "rotate(180deg)";
            } else {
                // MODO COLAPSAR: Buscamos las que marcamos como 'expanded'
                const expandedRows = document.querySelectorAll(`.${type}-row.expanded`);
                expandedRows.forEach(row => {
                    row.classList.add('hidden');
                    row.classList.remove('expanded');
                });
                span.textContent = type === 'fito' ? "Ver todos los compuestos" : "Ver todos los parámetros";
                btn.querySelector('svg').style.transform = "rotate(0deg)";
                
                // Scroll suave hacia arriba de la tabla para no perderse
                btn.closest('.overflow-hidden').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>
</body>
</html>