<script>
	var map;
	var marker;

	// Initialize and add the map
	function initMap() {
		var mark = true;
		// The location
		@if(isset($ficha) && $ficha->latitud && $ficha->longitud)

			var location = {lat: {{ $ficha->latitud }}, lng: {{ $ficha->longitud }} };
		@else
			@if(isset($ficha) && $ficha->zona_UTM && $ficha->X && $ficha->Y)
				var latlon = utm.toLatLon({{ $ficha->X }}, {{ $ficha->Y }}, {{ $ficha->zona_UTM }}, '{{ config('carta.bandaUTM') }}');
				var location = {lat: latlon.latitude, lng: latlon.longitude };
			@else
				// si no centramos en el Pico de las Nieves
		  		var location = {lat: {{ config('carta.coords_pico_nieves.latitud') }}, lng: {{ config('carta.coords_pico_nieves.longitud') }} };
		  		mark = false;
			@endif
		@endif
		// The map
		map = new google.maps.Map(
		  document.getElementById('map'), {zoom: 12, center: location});
		// The marker
		if (mark) {
			marker = new google.maps.Marker({position: location, map: map});
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