@extends('layouts.public')

@section('content')
<div id="app-search">

	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item active" aria-current="page">Carta etnográfica de Gran Canaria</li>
	  </ol>
	</nav>

	@include('shared_partials.errors')

    <div class="card">
        <div class="card-header">
            <!--- SELECT PARA EL BUSCADOR -->
            @include('shared_partials.fichas.search.select')

            <!--- TÍTULO Y DESCRIPCIÓN PARA EL BUSCADOR -->
            @include('shared_partials.fichas.search.title')
        </div>
        <div class="card-body" v-cloak>
            <!--- CAMPOS PARA EL BUSCADOR -->
            @include('shared_partials.fichas.search.fields')
        </div>
    </div>
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
				busqueda_select: @if(old('busqueda_select')) '{{ old('busqueda_select') }}' @else 'municipios' @endif,
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
