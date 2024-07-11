<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Pesanan</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script>
        let map;
        let marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -6.200000, lng: 106.816666 },
                zoom: 12
            });

            marker = new google.maps.Marker({
                map: map,
                position: { lat: -6.200000, lng: 106.816666 }
            });

            updateLocation();
        }

        function updateLocation() {
            const orderId = "12345"; // Ganti dengan ID pesanan Anda

            $.get(`get_latest_location.php?order_id=${orderId}`, function(data) {
                const position = JSON.parse(data);
                const latLng = new google.maps.LatLng(position.latitude, position.longitude);
                marker.setPosition(latLng);
                map.setCenter(latLng);

                // Update setiap 5 detik
                setTimeout(updateLocation, 5000);
            });
        }

        window.onload = initMap;
    </script>
</body>
</html>
