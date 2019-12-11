<script>
	var vm = new Vue({
		el: "#{{ $id }}",
		data: {
			@role('admin')
			isla: '',
			@endrole
			@role('collaborator')
			isla: '{{ config('carta.isla') }}',
			@endrole
			islas: {!! $islas->toJson() !!},
			municipio: '',
			localidad: '',
			municipios: @if ($municipios) {!! $municipios->toJson() !!} @else [] @endif,
			localidades: [],
			actividad: '',
			actividades: {!! $actividades->toJson() !!},
			grupo: '',
			grupos: {!! $grupos->toJson() !!},
			tipo: '',
			tipos: {!! $tipos->toJson() !!},
			antiguedad: '',
			antiguedades: {!! $antiguedades->toJson() !!},
			uso_actual: '',
			usos_actuales: {!! $usos_actuales->toJson() !!},
			estado: '',
			estados: {!! $estados->toJson() !!},
			fragilidad: '',
			fragilidades: {!! $fragilidades->toJson() !!},
			valor_cientifico: '',
			valores_cientificos: {!! $valores_cientificos->toJson() !!},
			propiedad: '',
			propiedades: {!! $propiedades->toJson() !!},
			clasificacion_suelo: '',
			clasificaciones_suelo: {!! $clasificaciones_suelo->toJson() !!},
			calificacion_suelo: '',
			calificaciones_suelo: {!! $calificaciones_suelo->toJson() !!},
			grado_proteccion: '',
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
			filter: null,
		},
		methods: {
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
		},
	});
</script>