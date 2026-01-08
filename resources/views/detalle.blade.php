<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $planta->preview['vernacularName'] ?? 'Detalle de Planta' }} - BotanicApp</title>
    {{-- TailwindCSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-400 text-gray-800 font-sans">

    {{-- ================= HEADER ================= --}}
    <header class="bg-gray-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex space-x-8">
                <a href="{{ route('inicio') }}" class="hover:text-green-400 transition font-medium">Inicio</a>
            </div>
            <div>
                {{-- Logo --}}
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

    {{-- ================= PREPARACIÓN DE DATOS ================= --}}
    @php
        // 1. Normalización de Arrays (Minúsculas preferentemente)
        $preview    = $planta->preview ?? $planta->PREVIEW ?? [];
        $tax        = $planta->taxonomico ?? $planta->TAXONOMICO ?? [];
        $fito       = $planta->fitoquimico ?? $planta->FITOQUIMICO ?? [];
        $fisico     = $planta->fisicoquimico ?? $planta->FISICOQUIMICO ?? [];

        // 2. Datos Texto
        $nombreComun = $preview['vernacularName'] ?? $preview['nombre_comun'] ?? 'Sin Nombre Común';
        $nombreCientifico = $preview['scientificName'] ?? $preview['nombre_cientifico'] ?? 'Sin Nombre Científico';
        $descripcion = $preview['descripcion'] ?? 'No hay descripción disponible.';

        // 3. Lógica de Imagen (Idéntica a inicio.blade.php)
        $rutaImagen = $preview['imagen'] ?? $preview['associatedMedia'][0] ?? null;
        if ($rutaImagen) {
            $imagenUrl = str_starts_with($rutaImagen, 'http') ? $rutaImagen : asset('storage/' . $rutaImagen);
        } else {
            $imagenUrl = asset('/' . "PlantaIcono.png");
        }
    @endphp

    {{-- ================= CONTENIDO PRINCIPAL ================= --}}
    <main class="max-w-7xl mx-auto px-6 py-10">

        {{-- Navegación Breadcrumb --}}
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

        {{-- SECCIÓN 1: TARJETA HERO (Imagen + Info Principal) --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-10 border border-gray-100">
            <div class="md:flex h-auto lg:h-[500px]">
                {{-- Imagen --}}
                <div class="md:w-1/2 relative bg-gray-200 h-80 md:h-full group">
                    <img src="{{ $imagenUrl }}" 
                         alt="{{ $nombreComun }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute top-4 left-4 bg-black/60 text-white px-3 py-1 rounded-full text-xs font-mono backdrop-blur-sm">
                        ID: {{ $planta->taxonID }}
                    </div>
                </div>

                {{-- Información --}}
                <div class="p-8 md:w-1/2 flex flex-col bg-white">
                    
                    {{-- Badge Superior --}}
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-white bg-gray-900 rounded-sm">
                            Ficha Botánica
                        </span>
                    </div>
                    
                    {{-- Títulos --}}
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-1">
                        {{ $nombreComun }}
                    </h1>
                    
                    <h2 class="text-2xl text-green-700 italic font-serif mb-6 pb-4 border-b border-gray-100 inline-block w-full">
                        {{ $nombreCientifico }}
                    </h2>

                    {{-- Descripción con scroll si es muy larga --}}
                    <div class="prose prose-sm prose-green text-gray-600 leading-relaxed mb-8 overflow-y-auto max-h-40 pr-2">
                        <p>{{ $descripcion }}</p>
                    </div>

                    {{-- NUEVO DISEÑO: Datos Taxonómicos Rápidos (Estilo Ficha) --}}
                    <div class="mt-auto pt-6 border-t border-gray-100 w-full">
                        <div class="grid grid-cols-2 gap-6">
                            
                            {{-- Familia --}}
                            @if(!empty($tax['family']))
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Familia</span>
                                    <span class="text-lg font-serif text-gray-800 italic border-l-2 border-green-500 pl-3">
                                        {{ $tax['family'] }}
                                    </span>
                                </div>
                            @endif

                            {{-- Reino --}}
                            @if(!empty($tax['kingdom']))
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Reino</span>
                                    <span class="text-lg font-serif text-gray-800 italic border-l-2 border-purple-500 pl-3">
                                        {{ $tax['kingdom'] }}
                                    </span>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- SECCIÓN 2: GRID DE DATOS (Taxonomía/Mapa + Tablas) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- COLUMNA IZQUIERDA (4 spans): Taxonomía y Futuro Mapa --}}
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
                                            {{-- CASO 1: El valor es un Array (Ej: atributos_extra / subclases) --}}
                                            @if(is_array($val))
                                                @foreach($val as $subKey => $subVal)
                                                    <tr class="hover:bg-gray-50 transition">
                                                        <td class="py-3 px-6 font-medium text-gray-500 capitalize bg-gray-50 w-1/3">
                                                            {{-- Imprimimos la clave interna (Ej: Subclase, Super Orden) --}}
                                                            {{ $subKey }}
                                                        </td>
                                                        <td class="py-3 px-6 text-gray-800 font-semibold italic">
                                                            {{ $subVal }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            {{-- CASO 2: El valor es Texto normal (Ej: Reino, Familia) --}}
                                            @elseif(is_string($val) || is_numeric($val))
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="py-3 px-6 font-medium text-gray-500 capitalize bg-gray-50 w-1/3">
                                                        {{ $key }}
                                                    </td>
                                                    <td class="py-3 px-6 text-gray-800 font-semibold italic">
                                                        {{ $val }}
                                                    </td>
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
                {{-- ESPACIO PARA EL FUTURO MAPA (Map Placeholder) --}}
                {{-- ================================================= --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-gray-800 px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Ubicación Geográfica
                        </h3>
                    </div>
                    
                    {{-- Contenedor del Mapa --}}
                    <div class="h-64 bg-gray-100 flex flex-col items-center justify-center text-gray-400 relative">
                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        <span class="text-sm font-medium">Mapa Próximamente</span>
                        <p class="text-xs px-8 text-center mt-2">Aquí se visualizará la distribución geográfica de la especie.</p>
                    </div>
                </div>

            </div>

            {{-- COLUMNA DERECHA (8 spans): Tablas Científicas --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- Tabla Fitoquímica --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-green-50 to-white">
                        <h3 class="text-xl font-bold text-gray-800 text-green-700">Análisis Fitoquímico</h3>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">
                            {{ count($fito) }} Registros
                        </span>
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
                            <tbody class="divide-y divide-gray-100">
                                @foreach($fito as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-6 font-bold text-gray-800">
                                            {{ $item['measurementType'] ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6 text-green-600 font-bold font-mono">
                                            {{ $item['measurementValue'] ?? '--' }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-600">
                                            {{ $item['measurementMethod'] ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-500 italic text-xs">
                                            {{ $item['measurementRemarks'] ?? '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="p-8 text-center text-gray-400">
                                No hay información fitoquímica registrada.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tabla Fisicoquímica --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-blue-50 to-white">
                        <h3 class="text-xl font-bold text-gray-800 text-blue-700">Análisis Fisicoquímico</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">
                            {{ count($fisico) }} Registros
                        </span>
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
                            <tbody class="divide-y divide-gray-100">
                                @foreach($fisico as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-6 font-bold text-gray-800">
                                            {{ $item['measurementType'] ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6 text-blue-600 font-bold font-mono">
                                            {{ $item['measurementValue'] ?? '--' }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-600">
                                            {{ $item['measurementUnit'] ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-500">
                                            {{ $item['measurementMethod'] ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="p-8 text-center text-gray-400">
                                No hay información fisicoquímica registrada.
                            </div>
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

</body>

</html>