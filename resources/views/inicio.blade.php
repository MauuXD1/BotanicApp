<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Plantas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-gray-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex space-x-8">
                <a href="{{ route('inicio') }}" class="hover:text-green-300 transition">Inicio</a>
            </div>

            <div>
                {{-- Si no tienes logo.webp, pon un texto temporal --}}
                @if(file_exists(public_path('logo.webp')))
                    <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-10">
                @else
                    <span class="text-2xl font-bold text-green-500">BotanicApp</span>
                @endif
            </div>

            <div class="flex space-x-8">
                <a href="/admin" class="text-blue-200 hover:text-white transition bg-blue-900 px-4 py-2 rounded-lg text-sm">Panel Admin</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 flex-grow">
        <form method="GET" action="{{ route('inicio') }}" class="flex flex-wrap gap-4 bg-white p-6 rounded-xl shadow-sm mb-8">
            {{-- Input de búsqueda principal --}}
            <div class="flex-1 min-w-[300px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la planta</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" 
                    placeholder="Ej: Menta o Mentha spicata..." 
                    class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            {{-- Filtro por Familia (Taxonómico) --}}
            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Familia</label>
                <input type="text" name="family" value="{{ request('family') }}" placeholder="Ej: Lamiaceae"
                    class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-6 rounded-lg transition shadow-md">
                    Aplicar Filtros
                </button>
                @if(request()->anyFilled(['buscar', 'family', 'order']))
                    <a href="{{ route('inicio') }}" class="ml-2 text-sm text-red-500 hover:underline py-2">Limpiar</a>
                @endif
            </div>
        </form>



        {{-- Galería --}}
        @if($items->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl shadow-sm">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-gray-500 text-xl font-medium">No se encontraron plantas.</p>
                <a href="{{ route('inicio') }}" class="mt-4 text-green-600 hover:underline">Ver todas</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($items as $item)
                    @php
                        // 1. Accedemos a 'preview' en minúsculas (tal como salió en el debug)
                        $data = $item->preview ?? [];

                        // 2. Nombres
                        $nombreComun = $data['vernacularName'] ?? 'Nombre Desconocido';
                        $nombreCientifico = $data['scientificName'] ?? '';
                        $descripcion = $data['descripcion'] ?? '';

                        // 3. Imagen
                        $rutaImagen = $data['imagen'] ?? null;
                        if (is_string($rutaImagen) && strtoupper($rutaImagen) === 'N/A') {
                            $rutaImagen = null;
                        }
                        $imagenUrl = asset('storage/' . "plantas/PlantaIcono.png"); // Valor por defecto

                        if ($rutaImagen) {
                            // Comprobamos si es una URL externa (http o https)
                            if (filter_var($rutaImagen, FILTER_VALIDATE_URL)) {
                                // Si es una URL válida y externa, la usamos directamente
                                $imagenUrl = $rutaImagen;
                            } else {
                                // Si no es una URL externa, asumimos que es una ruta local subida
                                // que necesita el prefijo 'storage/' de Laravel.
                                $imagenUrl = asset('storage/' . $rutaImagen);
                            }
                        }
                    @endphp

                    <div class="bg-white rounded-xl shadow hover:shadow-lg hover:scale-105 transform transition duration-300 p-3 flex flex-col h-full">
                        
                        {{-- Imagen --}}
                        <div class="relative overflow-hidden rounded-lg h-48 bg-gray-100">
                            <img src="{{ $imagenUrl }}" 
                                alt="{{ $nombreComun }}" 
                                class="w-full h-full object-cover">
                        </div>

                        {{-- Contenido --}}
                        <div class="mt-4 text-center flex-grow">
                            {{-- Nombre Común --}}
                            <h6 class="font-bold text-gray-800 text-xl leading-tight">
                                {{ $nombreComun }}
                            </h6>
                            
                            {{-- Nombre Científico --}}
                            @if($nombreCientifico)
                                <p class="text-sm text-green-600 italic mt-1 font-medium">
                                    {{ $nombreCientifico }}
                                </p>
                            @endif

                            <!-- {{-- Descripcion --}}
                            @if($descripcion)
                                <p class="text-sm text-green-600 italic mt-1 font-medium">
                                    {{ $descripcion }}
                                </p>
                            @endif -->
                        </div>

                        {{-- Botón --}}
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            {{-- Usamos $item->taxonID (según tu debug) --}}
                            <a href="{{ route('planta.detalle', ['id' => $item->taxonID]) }}" 
                            class="block w-full py-2 bg-green-50 text-green-700 text-sm font-semibold rounded-lg text-center hover:bg-green-600 hover:text-white transition-colors">
                                Ver Ficha
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        {{-- Paginación --}}
        <div class="mt-8">
            {{-- 
                appends(request()->query()) asegura que los filtros de búsqueda 
                se mantengan al cambiar de página 
            --}}
            {{ $items->appends(request()->query())->links() }}
        </div>

    </main>
    
    <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} BotanicApp. Todos los derechos reservados.
        </div>
    </footer>

</body>
@if($items->isNotEmpty())
    <div class="bg-black text-green-400 p-4 m-4 rounded overflow-auto h-auto text-xs font-mono">
        <strong>DEBUG TOTAL:</strong>
        @php
            $debugItem = $items->first();
        @endphp
        {{-- Esto imprimirá TODOS los atributos del objeto --}}
        @dump($debugItem->getAttributes()) 
    </div>
@endif
</html>