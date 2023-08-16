<!DOCTYPE html>
<html>

<head>
    <title>Get Location with Radius Indicator using Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <button id="refreshButton">Refresh Location</button>
    <button id="submitButton">Submit Location</button>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([0, 0], 15);

        // Add a tile layer to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Set the latitude and longitude of your office
        var officeLocation = ['-7.2811509', '112.7973146'];
        var radius = 50; // Radius in meters

        var officeIcon = L.icon({
            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34]
        });

        // Create a marker for your office's location
        var officeMarker = L.marker(officeLocation, {
            icon: officeIcon
        }).addTo(map).bindPopup("Your Office");

        var userMarker;

        // Get the user's location
        function onLocationFound(e) {
            var userLocation = e.latlng;

            if (userMarker) {
                map.removeLayer(userMarker);
            }

            // Create a marker for the user's location
            userMarker = L.marker(userLocation).addTo(map).bindPopup("Your Location").openPopup();

            // Create a circle radius indicator
            var radiusCircle = L.circle(officeLocation, {
                color: 'green',
                fillColor: 'rgba(255, 0, 0, 0)',
                fillOpacity: 0.3,
                radius: radius
            }).addTo(map);

            // Fit the map bounds to include the user's location and radius circle
            var bounds = L.latLngBounds([userLocation, officeLocation, radiusCircle.getBounds()]);
            map.fitBounds(bounds);
        }

        function onLocationError(e) {
            if (e.code === 1) {
                alert("Geolocation access has been denied. Please enable geolocation in your browser settings.");
            } else {
                alert("Error getting your location: " + e.message);
            }
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        // Locate the user
        map.locate({
            setView: true,
            maxZoom: 16
        });

        function refreshLocation() {
            map.locate({
                setView: false,
            });
        }

        function submitLocation() {
            if (userMarker) {
                var userLocation = userMarker.getLatLng();

                // Calculate distance between user location and office location
                var distance = userLocation.distanceTo(L.latLng(officeLocation));

                if (distance > radius) {
                    alert("You are outside the allowed area.");
                } else {
                    alert("Latitude: " + userLocation.lat + "\nLongitude: " + userLocation.lng);
                }
            } else {
                alert("User location not available.");
            }
        }

        var refreshButton = document.getElementById('refreshButton');
        refreshButton.addEventListener('click', refreshLocation);
        var submitButton = document.getElementById('submitButton');
        submitButton.addEventListener('click', submitLocation);
    </script>
</body>

</html>
