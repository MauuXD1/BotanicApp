<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div style="display: flex; flex-wrap: wrap; gap: 20px; background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
    
    <div style="flex: 1; min-width: 250px; display: flex; flex-direction: column; justify-content: center;">
        
        <h4 style="margin-top: 0; color: #475569; font-weight: bold;">📍 Geolocalización</h4>
        <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">
            Arrastra el marcador rojo en el mapa para obtener la ubicación exacta.
        </p>

        <div style="background: white; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; margin-bottom: 10px;">
            <label style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: bold; display: block;">Latitud</label>
            <span id="panel-lat" style="font-family: monospace; font-size: 18px; color: #0f172a; font-weight: bold; display: block;">---</span>
        </div>

        <div style="background: white; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; margin-bottom: 20px;">
            <label style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: bold; display: block;">Longitud</label>
            <span id="panel-lng" style="font-family: monospace; font-size: 18px; color: #0f172a; font-weight: bold; display: block;">---</span>
        </div>

        <div style="font-size: 11px; color: #ef4444; background: #fee2e2; padding: 8px; border-radius: 4px;">
            ⚠️ Si los campos de abajo no se llenan solos, copia estos números manualmente.
        </div>
    </div>

    <div style="flex: 2; min-width: 300px;">
        <div id="map-{{ $uniqueId }}" style="width: 100%; height: 400px; border-radius: 8px; border: 2px solid #cbd5e1; z-index: 1;"></div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- CONFIGURACIÓN ---
        var lat = {{ $lat ?? -0.201562 }};
        var lng = {{ $lng ?? -78.479427 }};
        
        var map = L.map('map-{{ $uniqueId }}').setView([lat, lng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

        // --- REFERENCIAS AL PANEL IZQUIERDO ---
        const panelLat = document.getElementById('panel-lat');
        const panelLng = document.getElementById('panel-lng');

        // --- FUNCIÓN QUE ACTUALIZA TODO ---
        function updateAll(lat, lng) {
            // 1. Actualizar el Panel Izquierdo (Visual)
            if(panelLat) panelLat.innerText = lat.toFixed(6);
            if(panelLng) panelLng.innerText = lng.toFixed(6);

            // 2. Intentar llenar los Inputs de MoonShine (Datos reales)
            const inputLat = document.querySelector('input[name="lat_temp"]');
            const inputLng = document.querySelector('input[name="lng_temp"]');
            
            if(inputLat && inputLng) {
                inputLat.value = lat.toFixed(6);
                inputLng.value = lng.toFixed(6);
                // Disparar evento para que MoonShine se entere
                inputLat.dispatchEvent(new Event('input', { bubbles: true }));
                inputLng.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }

        // --- EVENTOS DEL MAPA ---
        marker.on('drag', function(e) {
            var p = e.target.getLatLng();
            updateAll(p.lat, p.lng);
        });

        marker.on('dragend', function(e) {
            var p = e.target.getLatLng();
            updateAll(p.lat, p.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateAll(e.latlng.lat, e.latlng.lng);
        });

        // Inicializar
        updateAll(lat, lng);
        setTimeout(() => { map.invalidateSize(); }, 500);
    });
</script>