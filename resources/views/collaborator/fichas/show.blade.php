@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row mb-2">
		<div class="col-lg-2 col-md-2 col-12">
			<h3>FICHA</h3>
		</div>
		<div class="col-lg-2 col-md-2 col-12 mb-2">
			@if($pending)
				<button class="btn btn-secondary btn-block" title="Hay una petición pendiente" disabled>Editar</button>
			@else()
				<a href="{{ route('collaborator.fichas.edit', $ficha->id) }}" class="btn btn-outline-secondary btn-block">Editar</a>
			@endif
		</div>
		<div class="col-lg-2 col-md-2 col-12 mb-2">
			<a class="btn btn-outline-secondary btn-block" href="{{ route('fichas.download', $ficha->cod_ficha) }}" class="btn btn-block">Imprimir</a>
		</div>
	</div>

	@if($pending)
	<div class="alert alert-warning" role="alert">
	  Esta ficha tiene alguna petición de edición pendiente de moderar. <a href="{{ route('collaborator.peticiones.show', $pending->id ) }}">Ver petición.</a>
	</div>
	@endif

{{-- 	<div class="row mb-2">
		<div class="col-lg-12 text-right">
			<i class="fas fa-angle-left"></i> Ficha anterior | Ficha siguiente <i class="fas fa-angle-right"></i>
		</div>
	</div> --}}

	<div class="row align-items-center mb-5">
		<div class="col-lg-5">
			@include('shared_partials.fichas.show.fotos')
		</div>
		@isset($map)
		<div class="col-lg-7 py-2 map-show">
			{!! $map !!}
		</div>
		@endisset
	</div>

	@include('shared_partials.fichas.show.datos')

</div>
@endsection
