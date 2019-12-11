@extends('layouts.admin')

@section('content')
<div id="ficha-form">

	<form v-on:submit.prevent="onSubmit('store-form')" id="store-form" action="{{ route('collaborator.fichas.store') }}" method="post" enctype="multipart/form-data">
		@csrf

		<div class="container">
			<div class="row mb-4">
				<div class="col-lg-4 col-md-4 mb-2">
					<h3>CREAR FICHA</h3>
				</div>
				<div class="col-lg-2 col-md-2 col-12 mb-4">
					<button type="submit" class="btn btn-outline-success btn-block">Crear</button>
				</div>
				<div class="col-lg-2 col-md-2 col-12">
					<a href="{{ route('collaborator.fichas.index') }}" class="btn btn-outline-danger btn-block">Cancelar</a>
				</div>	
			</div>
		</div>

		@include('shared_partials.fichas.errors')

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

		<br>

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