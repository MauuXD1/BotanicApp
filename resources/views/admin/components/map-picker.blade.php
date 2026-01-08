<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="my-4">
    <div id="map-{{ $uniqueId }}" style="height: 400px; width: 100%; border-radius: 0.5rem; z-index: 1;"></div>
    <div class="text-xs text-gray-500 mt-2">
        Mueve el marcador para capturar las coordenadas.
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. CONFIGURACIÓN DEL MAPA ---
        var lat = {{ $lat ?? -0.201562 }};
        var lng = {{ $lng ?? -78.479427 }};
        
        var map = L.map('map-{{ $uniqueId }}').setView([lat, lng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

        // --- 2. LÓGICA DE CONEXIÓN (AQUÍ ESTABA EL FALLO) ---
        
        function getInputs() {
            // Buscamos inputs que tengan el atributo name="lat_temp" o name="lng_temp"
            // Esto es más seguro que usar IDs
            const latInput = document.querySelector('input[name="lat_temp"]');
            const lngInput = document.querySelector('input[name="lng_temp"]');
            
            if (!latInput || !lngInput) {
                console.error("MoonShine Map: No encontré los inputs 'lat_temp' o 'lng_temp'. Revisa el formulario.");
            }
            return { latInput, lngInput };
        }

        function updateInputs(lat, lng) {
            const { latInput, lngInput } = getInputs();

            if(latInput && lngInput) {
                // Actualizamos el valor
                latInput.value = lat;
                lngInput.value = lng;
                
                // ¡IMPORTANTE! Avisamos al navegador que hubo un cambio
                // Esto despierta a MoonShine/AlpineJS si están "dormidos"
                latInput.dispatchEvent(new Event('input', { bubbles: true }));
                lngInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }

        // Evento: Al soltar el marcador (Drag End)
        marker.on('dragend', function(e) {
            var position = e.target.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        // Evento: Al hacer clic en el mapa
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        // Evento: Bidireccional (Si escribes manual, mueve el mapa)
        const { latInput, lngInput } = getInputs();
        
        function updateMarkerFromManualInput() {
            if(!latInput || !lngInput) return;
            
            var newLat = parseFloat(latInput.value);
            var newLng = parseFloat(lngInput.value);

            if (!isNaN(newLat) && !isNaN(newLng)) {
                var newLatLng = new L.LatLng(newLat, newLng);
                marker.setLatLng(newLatLng);
                map.panTo(newLatLng);
            }
        }

        if(latInput) latInput.addEventListener('input', updateMarkerFromManualInput);
        if(lngInput) lngInput.addEventListener('input', updateMarkerFromManualInput);

        // Hack visual para que el mapa cargue bien las baldosas
        setTimeout(() => { map.invalidateSize(); }, 500);
    });
</script>