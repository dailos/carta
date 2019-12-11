@extends('layouts.admin')

@section('content')
<div id="ficha-form">

	<form id="update-form" v-on:submit.prevent="onSubmit('update-form')" action="{{ route('collaborator.fichas.update', $ficha->id) }}" method="post" enctype="multipart/form-data">
			@csrf
			@method('PUT')

		<div class="container">
			<div class="row mb-4">
				<div class="col-lg-6 col-md-4 mb-2">
					<h3>EDITAR FICHA</h3>
				</div>
				<div class="col-lg-2 col-md-4 col-12 mb-4">
					@if($pending)
						<button type="submit" class="btn btn-outline-success btn-block" title="Hay una petición pendiente" disabled>Guardar</button>
					@else()
						<button type="submit" class="btn btn-outline-success btn-block">Guardar</button>
					@endif
				</div>
				<div class="col-lg-2 col-md-2 col-12">
					<a href="{{ route('collaborator.fichas.show', $ficha->id) }}" class="btn btn-outline-danger btn-block">Cancelar</a>
				</div>	
			</div>
			
			@if($pending)
			<div class="alert alert-warning" role="alert">
			  Esta ficha tiene alguna petición de edición pendiente de moderar. <a href="{{ route('collaborator.peticiones.show', $pending->id ) }}">Ver petición.</a>
			</div>
			@endif

			@include('shared_partials.fichas.errors')
		</div>

		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-12">
					@include('shared_partials.fichas.fotos')
				</div>
				<div class="col-lg-6 col-12">
					@include('shared_partials.fichas.menu')
				</div>
			</div>
		</div>

		<div v-show="active == 'localizacion'" class="container">
			@include('shared_partials.fichas.localizacion')										
		</div>

		<div v-show="active == 'coordenadas'" class="container">
			@include('shared_partials.fichas.coordenadas')										
		</div>

		<div v-show="active == 'clasificacion'" class="container">
			@include('shared_partials.fichas.clasificacion')										
		</div>

		<div v-show="active == 'datos_asociados'" class="container">
			@include('shared_partials.fichas.datos')										
		</div>

		<div v-show="active == 'contactos'" class="container">
			@include('shared_partials.fichas.contactos')										
		</div>

		<div v-show="active == 'info_adicional'" class="container">
			@include('shared_partials.fichas.info_adicional')
		</div>

	</form>

</div>
@endsection

@push('scripts')
	@include('shared_partials.fichas.scripts')
@endpush

@push('scripts')
	@include('shared_partials.fichas.scripts.popovererrors')
@endpush