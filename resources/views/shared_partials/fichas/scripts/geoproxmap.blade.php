<script>
  var marker;
  var circle;

  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 9.5,
        center: {lat: {{ config('carta.coords_pico_nieves.latitud') }}, lng: {{ config('carta.coords_pico_nieves.longitud') }} }
      });

    map.addListener('click', function(e) {
      document.getElementById('latitud').value = e.latLng.lat();
      document.getElementById('longitud').value = e.latLng.lng();
      var radius = Number(document.getElementById('radio').value);

      deleteMarker();
      deleteCircle();
      placeMarkerAndPanTo(e.latLng, map);

      // Add the circle for this city to the map.
      circle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: e.latLng,
        radius: radius
      });

      circle.addListener('click', function(e) {
        deleteCircle();
      });

    });
  }

  // Removes the markers from the map, but keeps them in the array.
  function clearMarker() {
    marker.setMap(null);
  }

  // Deletes all markers in the array by removing references to them.
  function deleteMarker() {
    if (marker) {
      clearMarker();
      marker = null;
    }
  }

  function placeMarkerAndPanTo(latLng, map) {
    marker = new google.maps.Marker({
      position: latLng,
      map: map
    });
    map.panTo(latLng);
  }

  function deleteCircle() {
    if (circle) {
      circle.setMap(null);
    }
  }
</script>

<!--Load the API from the specified URL
* The async attribute allows the browser to render the page while the API loads
* The key parameter will contain your own API key (which is not needed for this tutorial)
* The callback parameter executes the initMap() function
-->
<script async defer
src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap">
</script>
