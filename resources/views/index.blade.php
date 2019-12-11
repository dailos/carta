@extends('layouts.public')

@section('content')
<div id="app-search">

	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item active" aria-current="page">Carta etnográfica de Gran Canaria</li>
	  </ol>
	</nav>

	@include('shared_partials.errors')

	<!--- TÍTULO Y DESCRIPCIÓN PARA EL BUSCADOR -->
	@include('shared_partials.fichas.search.title')
	
	<!--- SELECT PARA EL BUSCADOR -->
	@include('shared_partials.fichas.search.select')
	
	<!--- CAMPOS PARA EL BUSCADOR -->
	@include('shared_partials.fichas.search.fields')

	
	<!--- SELECT PARA EL POR ZONA --> 	
	<div class="row mt-5">
		<div class="col-lg-4"></div>
		<div class="col-lg-4"></div>
		<div class="col-lg-4">

		  <select v-model="municipio_buscador" class="custom-select cajadelbuscador" id="inputGroupSelect01">
				<option value="-">Todos los municipios</option>
				<option v-for="municipio in municipios" :value="municipio.id" v-text="municipio.text"></option>
		  </select>

		</div>

	</div>	
	<br>	
	<!--- IMAGENES DE 3 EN . --> 
	@include('fichas.partials.municipios')
	
</div>
@endsection

@push('scripts')
	@include('shared_partials.fichas.scripts.geoproxmap')
@endpush

@push('scripts')
	<script>
		var vm = new Vue({
			el: "#app-search",
			data: {
				busqueda_select: @if(old('busqueda_select')) '{{ old('busqueda_select') }}' @else '' @endif,
				municipios: {!! $municipios->toJson() !!},
				actividades: {!! $actividades->toJson() !!},
				grupos: {!! $grupos->toJson() !!},
				tipos: {!! $tipos->toJson() !!},
				placeholder_municipio: "Seleccione un municipio",
				placeholder_localidad: "Seleccione una localidad",
				placeholder_actividad: "Seleccione actividad",
				placeholder_grupo: "Seleccione grupo",
				placeholder_tipo: "Seleccione tipo",
				allow: true,
				radio: 5000,
				municipio_buscador: '-',
			}
		});
	</script>
@endpush