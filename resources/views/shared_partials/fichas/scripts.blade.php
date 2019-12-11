@push('scripts')
	@include('shared_partials.fichas.components')
@endpush

@push('scripts')
	@include('shared_partials.fichas.scripts.fichamap')
@endpush

<script>
	var vm = new Vue({
		el: "#ficha-form",
		components: {
		    'foto': ComponentFoto,
		    'enlace-url': ComponentEnlace,
		},
		data: {
			@role('admin')
			isla: '{{ form_value(isset($ficha) ? $ficha->isla_id : null, 'isla_id', $errors) }}',
			@endrole
			@role('collaborator')
			isla: '{{ config('carta.isla') }}',
			@endrole
			islas: {!! $islas->toJson() !!},
			municipio: '{{ form_value(isset($ficha) ? $ficha->municipio_id : null, 'municipio_id', $errors) }}',
			localidad: '{{ form_value(isset($ficha) ? $ficha->localidad_id : null, 'localidad_id', $errors) }}',
			municipios: @if (old('isla_id')) {!! App\Municipio::select('id', 'nombre as text')->where('isla_id', old('isla_id'))->get()->toJson() !!} @elseif ($municipios) {!! $municipios->toJson() !!} @else [] @endif,
			localidades: @if (old('municipio_id')) {!! App\Localidad::select('id', 'nombre as text')->where('municipio_id', old('municipio_id'))->get()->toJson() !!} @elseif (isset($localidades)) {!! $localidades->toJson() !!} @else [] @endif,
			actividades: {!! $actividades->toJson() !!},
			actividad: '{{ form_value(isset($ficha) ? $ficha->actividad_id : null, 'actividad_id', $errors) }}',
			grupos: {!! $grupos->toJson() !!},
			grupo: '{{ form_value(isset($ficha) ? $ficha->grupo_id : null, 'grupo_id', $errors) }}',
			tipos: {!! $tipos->toJson() !!},
			tipo: '{{ form_value(isset($ficha) ? $ficha->tipo_id : null, 'tipo_id', $errors) }}',
			antiguedad: '{{ form_value(isset($ficha) ? $ficha->antiguedad_id : null, 'antiguedad_id', $errors) }}',
			antiguedades: {!! $antiguedades->toJson() !!},
			uso_actual: '{{ form_value(isset($ficha) ? $ficha->uso_actual_id : null, 'uso_actual_id', $errors) }}',
			usos_actuales: {!! $usos_actuales->toJson() !!},
			estado: '{{ form_value(isset($ficha) ? $ficha->estado_id : null, 'estado_id', $errors) }}',
			estados: {!! $estados->toJson() !!},
			fragilidad: '{{ form_value(isset($ficha) ? $ficha->fragilidad_id : null, 'fragilidad_id', $errors) }}',
			fragilidades: {!! $fragilidades->toJson() !!},
			valor_cientifico: '{{ form_value(isset($ficha) ? $ficha->valor_cientifico_id : null, 'valor_cientifico_id', $errors) }}',
			valores_cientificos: {!! $valores_cientificos->toJson() !!},
			propiedad: '{{ form_value(isset($ficha) ? $ficha->propiedad_id : null, 'propiedad_id', $errors) }}',
			propiedades: {!! $propiedades->toJson() !!},
			clasificacion_suelo: '{{ form_value(isset($ficha) ? $ficha->clasificacion_suelo_id : null, 'clasificacion_suelo_id', $errors) }}',
			clasificaciones_suelo: {!! $clasificaciones_suelo->toJson() !!},
			calificacion_suelo: '{{ form_value(isset($ficha) ? $ficha->calificacion_suelo_id : null, 'calificacion_suelo_id', $errors) }}',
			calificaciones_suelo: {!! $calificaciones_suelo->toJson() !!},
			grado_proteccion: '{{ form_value(isset($ficha) ? $ficha->grado_proteccion_id : null, 'grado_proteccion_id', $errors) }}',
			grados_proteccion: {!! $grados_proteccion->toJson() !!},
			placeholder_isla: "Seleccione una isla",
			placeholder_municipio: "Seleccione un municipio",
			placeholder_localidad: "Seleccione una localidad",
			placeholder_actividad: "Seleccione actividad",
			placeholder_grupo: "Seleccione grupo",
			placeholder_tipo: "Seleccione tipo",
			placeholder_generico: "Seleccione valor",
			invalid: " is-invalid",
			allow: true,
			selected: '1', // Select - Tipo contacto
			option: 1, // Opción - id tipo contacto
			foto_items: [],
			nextFotoId: 1,
			maxFotoItems: {{ config('carta.maxFotos') }},
			croquis_items: [],
			nextCroquisId: 1,
			maxCroquisItems: {{ config('carta.maxCroquis') }},
			enlaceId: 1,
			enlace_items: [],
			videoId: 1,
			video_items: [],
			active: 'localizacion',
			activetab: 1, // Fotos tabs
			error_items: [],
			zona_utm: '{{ form_value(isset($ficha) ? $ficha->zona_UTM : '28', 'zona_UTM', $errors) }}',
			x: '{{ form_value(isset($ficha) ? $ficha->X : 0, 'X', $errors) }}',
			y: '{{ form_value(isset($ficha) ? $ficha->Y : 0, 'Y', $errors) }}',
			lat: '{{ form_value(isset($ficha) ? $ficha->latitud : null, 'latitud', $errors) }}',
			lon: '{{ form_value(isset($ficha) ? $ficha->longitud : null, 'longitud', $errors) }}',
		},
		created: function () {
			// Datos old de la request
			@if(old('fotos'))
				@foreach (old('fotos') as $key => $foto)
					this.foto_items.push({
						@if(isset($foto['id']))
						id: {{ $foto['id'] }},
						src: '{{ url('fotos/'. $foto['id']) }}',
						@else
						src: '',
						@endif
						id_name: 'fotos[' + this.nextFotoId + '][id]',
						input_file_name: 'fotos[' + this.nextFotoId + '][fichero]',
						input_file_id : 'foto_' + this.nextFotoId,
						key: this.nextFotoId,
					});

					this.nextFotoId++;
				@endforeach
			@elseif (!$errors->any())  // Si no es una redirección de validación Laravel
				@isset($ficha->fotos['fotos'])
					@foreach ($ficha->fotos['fotos'] as $foto_id)
					 	this.foto_items.push({
					 		id: {{ $foto_id }},
					 		id_name: 'fotos[' + this.nextFotoId + '][id]',
					 		src: '{{ url('fotos/'. $foto_id) }}',
					 		input_file_name: 'fotos[' + this.nextFotoId + '][fichero]',
					 		input_file_id : 'foto_' + this.nextFotoId,
					 		key: this.nextFotoId,
					 	});

					 	this.nextFotoId++;
					@endforeach
				@endisset
			@endif

			@if(old('croquis'))
				@foreach (old('croquis') as $key => $foto)
					this.croquis_items.push({
						@if(isset($foto['id']))
						id: {{ $foto['id'] }},
						src: '{{ url('fotos/'. $foto['id']) }}',
						@else
						src: '',
						@endif
						id_name: 'croquis[' + this.nextCroquisId + '][id]',
						input_file_name: 'croquis[' + this.nextCroquisId + '][fichero]',
						input_file_id : 'croquis_' + this.nextCroquisId,
						key: this.nextCroquisId,
					});

					this.nextCroquisId++;
				@endforeach
			@elseif (!$errors->any())
				@isset($ficha->fotos['croquis'])
					@foreach ($ficha->fotos['croquis'] as $foto_id)
					 	this.croquis_items.push({
					 		id: {{ $foto_id }},
					 		id_name: 'croquis[' + this.nextCroquisId + '][id]',
					 		src: '{{ url('fotos/'. $foto_id) }}',
					 		input_file_name: 'croquis[' + this.nextCroquisId + '][fichero]',
					 		input_file_id : 'croquis_' + this.nextCroquisId,
					 		key: this.nextCroquisId,
					 	});

					 	this.nextCroquisId++;
					@endforeach
				@endisset
			@endif

			// Datos old de la request
			@if(old('enlaces'))
				@foreach (old('enlaces') as $key => $enlace)
					this.enlace_items.push({
						id: this.enlaceId,
						text_name: 'enlaces[' + this.enlaceId + '][texto]',
						text_value: '{{ $enlace['texto'] }}',
						url_name: 'enlaces[' + this.enlaceId + '][url]',
						url_value: '{{ $enlace['url'] }}',
						key: this.enlaceId,
					});

					this.enlaceId++;
				@endforeach
			@elseif(!$errors->any())
			   // Datos de la ficha
			    @isset($ficha->enlaces)
				    @foreach ($ficha->enlaces as $value)
				    	this.enlace_items.push({
				    		id: this.enlaceId,
				    		text_name: 'enlaces[' + this.enlaceId + '][texto]',
				    		text_value: '{{ $value['texto'] }}',
				    		url_name: 'enlaces[' + this.enlaceId + '][url]',
				    		url_value: '{{ $value['url'] }}',
				    		key: this.enlaceId,
				    	});

				    	this.enlaceId++;
				    @endforeach
			    @endisset
			@endif

			@if(old('videos'))
				@foreach (old('videos') as $key => $video)
					this.video_items.push({
						id: this.videoId,
						text_name: 'multimedia[' + this.videoId + '][descripcion]',
						text_value: '{{ $video['descripcion'] }}',
						url_name: 'multimedia[' + this.videoId + '][url]',
						url_value: '{{ $video['url'] }}',
						key: 'video_' + this.videoId,
					});

					this.videoId++;
				@endforeach
			@elseif(!$errors->any())
				@isset($ficha->multimedia)
					@foreach ($ficha->multimedia as $value)
				    	this.video_items.push({
				    		id: this.videoId,
				    		text_name: 'multimedia[' + this.videoId + '][descripcion]',
				    		text_value: '{{ $value['descripcion'] }}',
				    		url_name: 'multimedia[' + this.videoId + '][url]',
				    		url_value: '{{ $value['url'] }}',
				    		key: 'video_' + this.videoId,
				    	});

				    	this.videoId++;
				    @endforeach
			    @endisset
			@endif
		},
		computed: {
		  latlon: {
		    // getter
		    get: function () {
		      return this.lat + ', ' + this.lon
		    },
		    // setter
		    set: function (newValue) {
		      this.lat = newValue
		      this.lon = newValue
		    }
		  }
		},
		methods: {
			onSubmit(input) {
				const form_id = document.getElementById(input);

				this.error_items = [];

				// Evaluar reglas de validación
				this.$validator.validate().then(result => {
			        if (!result) {
			        	for (i = 0; i < this.errors.all().length; i++) {
			        		this.error_items.push(this.errors.all()[i]);
			        	}
			        } 

		        	// Validar fotos
		        	if (this.foto_items.length == 0) {
		        		this.error_items.push("@lang('carta.foto_requerida')");
		        	}

		        	if (this.error_items.length == 0) {
						$( form_id ).submit();
		        	}
			    });
			},
			getMunicipios() {
				if (this.isla) {
					Vue.axios.get('/municipios/'+this.isla)
						.then((response) => {
							this.municipios = response.data;
						})
				} else {
					this.municipios = [];
				}
			},
			getLocalidades() {
				if (this.municipio) {
				Vue.axios.get('/localidades/'+this.municipio)
					.then((response) => {
						this.localidades = response.data;
					})
				} else if (this.isla_id){
					Vue.axios.get('/localidades/1')
					.then((response) => {
						this.localidades = response.data;
					})
					
				} else {
					this.localidades = [];
				}
			},
			addNewFoto: function (e) {
				this.foto_items.push({
					id: null,
					id_name: 'fotos[' + this.nextFotoId + '][id]',
					input_file_name: 'fotos[' + this.nextFotoId + '][fichero]',
					input_file_id: 'foto_' + this.nextFotoId,
					src: '',
					key: this.nextFotoId,
				});

				this.nextFotoId++;
			},
			removeFoto(index) {
				// Pop-up de confirmación sweetalert
				swal({
				  title: '@lang('carta.alert_title')',
				  text: "@lang('carta.alert_fotos_text')",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '@lang('carta.alert_cancel_button_text')',
				  confirmButtonText: '@lang('carta.alert_confirm_button_text')'
				}).then((result) => {
				  if (result.value) {
				    this.foto_items.splice(index, 1);
				  }
				})
			},
			addNewCroquis: function (e) {
				this.croquis_items.push({
					id: null,
					id_name: 'croquis[' + this.nextCroquisId + '][id]',
					input_file_name: 'croquis[' + this.nextCroquisId + '][fichero]',
					input_file_id: 'croquis_' + this.nextCroquisId,
					src: '',
					key: this.nextCroquisId,
				});

				this.nextCroquisId++;
			},
			removeCroquis(index) {
				// Pop-up de confirmación sweetalert
				swal({
				  title: '@lang('carta.alert_title')',
				  text: "@lang('carta.alert_fotos_text')",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '@lang('carta.alert_cancel_button_text')',
				  confirmButtonText: '@lang('carta.alert_confirm_button_text')'
				}).then((result) => {
				  if (result.value) {
				    this.croquis_items.splice(index, 1);
				  }
				})
			},
			addNewEnlace: function (e) {
				this.enlace_items.push({
					id: this.enlaceId,
					text_name: 'enlaces[' + this.enlaceId + '][texto]',
					text_value: '',
					url_name: 'enlaces[' + this.enlaceId + '][url]',
					url_value: '',
				});

				this.enlaceId++;
			},
			removeEnlace: function (index) {
				this.enlace_items.splice(index, 1);
				// Reorganiza los índices del array
				this.enlace_items.forEach(function(value, key) {
				     value.text_name = 'enlaces[' + (key+1) + '][texto]';
				     value.url_name = 'enlaces[' + (key+1) + '][url]';
				     Vue.set(vm.enlace_items, key, value);
				   });

				this.enlaceId = this.enlace_items.length+1;
			},
			addNewVideo: function (e) {
				this.video_items.push({
					text_name: 'multimedia[' + this.videoId + '][descripcion]',
					text_value: '',
					url_name: 'multimedia[' + this.videoId + '][url]',
					url_value: '',
				});

				this.videoId++;
			},
			removeVideo: function (index) {
				this.video_items.splice(index, 1);
				// Reorganiza los índices del array
				this.video_items.forEach(function(value, key) {
				     value.text_name = 'multimedia[' + (key+1) + '][descripcion]';
				     value.url_name = 'multimedia[' + (key+1) + '][url]';
				     Vue.set(vm.video_items, key, value);
				   });

				this.videoId = this.video_items.length+1;
			},
			localiza: function () {
				// Valida coordenadas
				this.$validator.validateAll('coords').then(result => {
					if (result) {
						// Convierte coordenadas a lat-lon
						var latlon = utm.toLatLon(this.x, this.y, this.zona_utm, '{{ config('carta.bandaUTM') }}');

						this.lat = Number((latlon.latitude).toFixed(12));
						this.lon = Number((latlon.longitude).toFixed(12));

						var location = {lat: latlon.latitude, lng: latlon.longitude };

						// Centra en la nueva localización
						map.setCenter(location);

						// Elimina marca antigua y crea nueva
						marker.setMap(null);
						marker = new google.maps.Marker({
					    	position: location,
		          			map: map
		        			});
					}
				});
			},
		}
	});


	$(function () {
        $('.datetimepicker').datetimepicker({
        	locale: 'es',
        	format: 'DD/MM/YYYY'
        });
    });
	
</script>