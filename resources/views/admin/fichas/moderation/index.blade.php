@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row mb-5">
		<div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-4">
			<h3 class="mb-0">PETICIONES</h3>
		</div>
		<div class="col-lg-2 col-md-4 col-sm-6 col-12">
			<a href="{{ route('admin.historial.index') }}" class="btn btn-outline-secondary btn-block">Historial</a>
		</div>	
	</div>

	<div class="row">
		<div class="col-lg-12 table-responsive">
			<table id="moderacion-table" class="table table-striped table-hover">
			  <thead>
			    <tr>
			      <th scope="col">Código ficha</th>
			      <th scope="col">Denominación</th>
			      <th scope="col">Creador / Autor</th>
			      <th scope="col">Fecha</th>
				  <th scope="col">Accion</th>
			      <th scope="col">Ver</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($fichas_pending as $ficha_pending)
			    <tr>
			      <td>{{ isset($ficha_pending->model) ? $ficha_pending->model->cod_ficha : '' }}</td>
			      <td>{{ isset($ficha_pending->model) ? $ficha_pending->model->denominacion : (isset($ficha_pending->fields['denominacion']) ? $ficha_pending->fields['denominacion'] : '') }}</td>
			      <td>@isset($ficha_pending->user){{ $ficha_pending->user->full_name }}@endisset</a>
			      </td>
			      <td>{{ $ficha_pending->created_at->format('Y/m/d H:i') }}</td>
			      <td>{{ __('carta.' . $ficha_pending->action) }}</td>
			      <td>{{ route('admin.moderacion.show', $ficha_pending->id) }}</td>
			    </tr>
			    @endforeach		    
			  </tbody>
			</table>
		</div>
	</div>
</div>

@endsection

@push('scripts')
	@include('shared_partials.fichas.moderation.datatable', ['table_id' => 'moderacion-table', 'column' => 5])
@endpush
