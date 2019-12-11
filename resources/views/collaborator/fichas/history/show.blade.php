@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row mb-5">
		<div class="col-lg-4 col-md-5 col-12 mb-2">
			<h3 class="mb-0">{{ strtoupper(__('carta.' . $moderableRecord->action)) }} FICHA</h3>
		</div>

		<div class="col-lg-4 col-md-4 col-12 mb-4">
			<span>Fecha petición: {{ $moderableRecord->created_at->format('Y/m/d H:i') }}</span>
		</div>

		<div class="col-lg-2 col-md-2 col-12">
			<a href="{{ route('collaborator.historial.index') }}" class="btn btn-outline-primary btn-block">Volver</a>
		</div>
	</div>

	@include('shared_partials.fichas.moderation.datos')

</div>

@endsection
