<!-- <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />

<div id='map' style='width: 400px; height: 300px;'></div>
<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2hpeGVoIiwiYSI6ImNrZjAwNmh1djBlazIyeGxudjR4cnFsY3EifQ.sDB6K4Dn05rsgQKIMnzjJA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        
        center: [-77.034084, 38.909671],
        zoom: 14
    });
</script> -->

<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" /> -->
<!-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script> -->
<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />

    <div class="col-md-6">
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" placeholder="latitude" class="form-control" id="latitude" name="latitude" value="{{ $latitude ?? '31.87067197598904'}}">
            <small class="help-block text-danger error-latitude"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" placeholder="Longitude" class="form-control" id="longitude" name="longitude" value="{{ $longitude ?? '54.36171474738359'}}">
            <small class="help-block text-danger error-longitude"></small>
        </div>
    </div>

<!-- <label for="latInput">Latitude</label>
<input id="latInput" />
<label for="lngInput">Longitude</label>
<input id="lngInput" /> -->
<div class="col-12">

    <div id="map" style="height : 500px"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script> -->

<script>
    var mapCenter = [ {{$latitude ?? '31.87067197598904'}}, {{$longitude ?? '54.36171474738359'}}];
    var mapboxAccessToken = 'pk.eyJ1Ijoic2hpeGVoIiwiYSI6ImNrZjAwNmh1djBlazIyeGxudjR4cnFsY3EifQ.sDB6K4Dn05rsgQKIMnzjJA';

    var map = L.map('map', {
        accessToken: mapboxAccessToken,
        style: 'https://openmaptiles.github.io/osm-bright-gl-style/style-cdn.json',

        center: mapCenter,
        style: 'mapbox://styles/mapbox/streets-v11',
        zoom: 3,

    }).setView(mapCenter, 5);


    // L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
    //     maxZoom: 18,
    //     attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
    //         '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
    //         'Imagery © <a href="http://mapbox.com">Mapbox</a>',
    //     id: 'examples.map-i875mjb7',
    //     noWrap: true
    // }).addTo(map);
    // var map = L.map('map').setView([51.505, -0.09], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);
    var updateMarker = function(lat, lng) {
        marker
            .setLatLng([lat, lng])
            .bindPopup("Your location :  " + marker.getLatLng().toString())
            .openPopup();
        return false;
    };

    map.on('click', function(e) {
        $('#latitude').val(e.latlng.lat);
        $('#longitude').val(e.latlng.lng);
        updateMarker(e.latlng.lat, e.latlng.lng);
    });

    var updateMarkerByInputs = function() {
        return updateMarker($('#latitude').val(), $('#longitude').val());
    }
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);
</script>