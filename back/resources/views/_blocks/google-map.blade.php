<section class="jumbotron text-center mb-0 pb-0">
    {{ $block['text'] }}
</section>
<section class="jumbotron text-center mb-0 google-map-wrap">
    <script>

        function initMap{{ $index }}() {
            // Create the map.
            const map = new google.maps.Map(document.querySelector(".google-map-wrap"), {
                zoom: {{ $block['zoom'] }},
                center: { lat: +'{{ $block['latitude'] }}', lng: +'{{ $block['longitude'] }}' },
                mapTypeId: "roadmap",
            });
            const infoWindow = new google.maps.InfoWindow();
            window.baseStations.forEach(baseStation => {
                const marker = new google.maps.Marker({
                    position: { lat: +baseStation.latitude, lng: +baseStation.longitude },
                    map,
                    title: baseStation.name,
                    optimized: false,
                });

                // Add a click listener for each marker, and set up the info window.
                marker.addListener("click", () => {
                    infoWindow.close();
                    infoWindow.setContent(marker.getTitle());
                    infoWindow.open(marker.getMap(), marker);
                });

                if (!baseStation.is_online) {
                    marker.setIcon('{{ asset('images/google-map-grey-pin.png') }}')
                    return;
                }

                const radiuses = [
                    { radius: 10000, color: "#00FF00"},
                    { radius: 30000, color: "#0000FF"},
                    { radius: 50000, color: "#FFFF00"},
                ];
                for (const { radius, color } of radiuses) {
                    new google.maps.Circle({
                        strokeColor: color,
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: color,
                        fillOpacity: 0.1,
                        map,
                        center: { lat: +baseStation.latitude, lng: +baseStation.longitude },
                        radius,
                    });
                }
            })
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ $settings['google_map_key'] }}&callback=initMap{{ $index }}&v=weekly"
        async
    ></script>
</section>
