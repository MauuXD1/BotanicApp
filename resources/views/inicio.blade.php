{{-- Haciendo una prueba con TailwindCSS --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    {{-- TailwindCSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    {{-- Header --}}
    <header class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            {{-- Izquierda --}}
            <div class="flex space-x-8">
                <a href="{{ route('inicio') }}" class="hover:text-green-300">Inicio</a>
                <a href="/admin" class="hover:text-green-300">Gestión</a>
            </div>

            {{-- Centro con logo --}}
            <div>
                {{-- Asegúrate de que este archivo exista en public/ --}}
                <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-10">
            </div>

            {{-- Derecha --}}
            <div class="flex space-x-8">
                <!-- <a href="#" class="hover:text-blue-300">Configuración</a> -->
                <a href="/admin/resource/moon-shine-user-resource/moon-shine-user-index-page" class="text-blue-200 hover:text-blue-500">Panel de Control</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-6">
        {{-- Barra de búsqueda --}}
        <form method="GET" action="{{ route('inicio')}}" class="flex flex-col sm:flex-row gap-3 mb-6">
            @csrf
            <input type="text" 
                   name="buscar"
                   placeholder="Buscar por nombre común o científico..." 
                   value="{{ request('buscar') }}"
                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2">
            <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">Buscar</button>
        </form>

        {{-- Galería --}}
        @if($items->isEmpty())
            <div class="text-center py-10">
                <p class="text-gray-500 text-lg">No hay plantas registradas que coincidan con tu búsqueda.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($items as $item)
                    {{-- Lógica para obtener la imagen de forma segura --}}
                    @php
                        // Intentamos obtener la primera imagen del array associatedMedia
                        // Si no existe o el array está vacío, usamos una imagen placeholder
                        $imagenUrl = $item->PREVIEW['associatedMedia'][0] ?? 'https://via.placeholder.com/300x200?text=Sin+Imagen';
                    @endphp

                    <div class="bg-white rounded-xl shadow hover:shadow-lg hover:scale-105 transform transition duration-300 p-3 flex flex-col h-full">
                        
                        {{-- Imagen --}}
                        <div class="relative overflow-hidden rounded-lg h-40">
                            <img src="{{ $imagenUrl }}" 
                                 alt="{{ $item->PREVIEW['vernacularName'] ?? 'Planta' }}" 
                                 class="w-full h-full object-cover">
                        </div>

                        {{-- Contenido --}}
                        <div class="mt-3 text-center flex-grow flex flex-col justify-center">
                            {{-- Nombre Común (Vernacular) --}}
                            <h6 class="font-bold text-gray-800 text-lg leading-tight">
                                {{ $item->PREVIEW['vernacularName'] ?? 'Nombre Desconocido' }}
                            </h6>
                            
                            {{-- Nombre Científico (Opcional, en cursiva) --}}
                            @if(isset($item->PREVIEW['scientificName']))
                                <p class="text-sm text-gray-500 italic mt-1">
                                    {{ $item->PREVIEW['scientificName'] }}
                                </p>
                            @endif
                        </div>

                        {{-- Botón opcional para ver detalles (usando el ID personalizado) --}}
                        <div class="mt-3">
                             {{-- Asumiendo que crearás una ruta llamada 'detalle' --}}
                            <a href="#" class="block w-full py-2 bg-green-100 text-green-700 text-sm font-semibold rounded text-center hover:bg-green-200 transition">
                                Ver Ficha
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>