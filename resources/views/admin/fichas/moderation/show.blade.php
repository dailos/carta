@extends('layouts.admin')

@section('content')
<div class="container">
	<div class="row mb-2">
		<div class="col-lg-4 col-md-6 col-12 mb-2">
			<h3 class="mb-0">{{ strtoupper(__('carta.' . $moderableRecord->action)) }} FICHA</h3>
		</div>
		<div class="col-lg-2 col-md-6 col-12 mb-4">
			<span>Fecha petición: {{ $moderableRecord->created_at->format('Y/m/d H:i') }}</span>
		</div>
		<div class="col-lg-2 col-md-4 col-12 mb-2">
			<a href="{{ route('admin.moderacion.edit', $moderableRecord->id) }}" class="btn btn-outline-primary btn-block">Editar</a>
		</div>
		<div class="col-lg-2 col-md-4 col-12 mb-2">
			<button type="" class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#aceptacion">Aceptar</button>
		</div>	
		<div class="col-lg-2 col-md-4 col-12 mb-2">
			<button type="" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#rechazo">Rechazar</button>
		</div>
	</div>

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

	@include('shared_partials.fichas.moderation.datos')

</div>

<div class="modal" id="aceptacion">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="color: green">Aceptado</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<form action="{{ route('admin.moderacion.accept') }}" method="post">
					@csrf
					<textarea class="form-control" placeholder="Añada un comentario" name="comment"></textarea>
					<input type="hidden" name="moderableId" value="{{ $moderableRecord->id }}">

					<div class="modal-footer">
						<button type="submit" class="btn" >Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>

<div class="modal" id="rechazo">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title" style="color: red">Rechazado</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<form action="{{ route('admin.moderacion.reject') }}" method="post">
					@csrf
					<textarea class="form-control" placeholder="Añada un comentario" name="comment" required></textarea>
					<input type="hidden" name="moderableId" value="{{ $moderableRecord->id }}">

					<div class="modal-footer">
						<button type="submit" class="btn">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>
@endsection

@push('scripts')
<script>
	$(function () {
	  $('[data-toggle="popover"]').popover({
	  	trigger: 'focus'
	  })
	});
</script>
@endpush