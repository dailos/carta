@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row mb-5">
		<div class="col-lg-6 col-md-4 col-sm-6 col-12 mb-4">
			<h3 class="mb-0">HISTORIAL DE PETICIONES</h3>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-6 col-12">
			<a href="{{ route('admin.moderacion.index') }}" class="btn btn-outline-secondary btn-block">Volver</a>
		</div>	
	</div>

	<div class="row">
		<div class="col-lg-12 table-responsive">
			<table id="history-table" class="table table-striped display" style="width:100%">
		        <thead>
		            <tr>
		            	<th scope="col">Código ficha</th>
		                <th scope="col">Denominación</th>
		                <th scope="col">Creador / Autor</th>
	                	<th scope="col">Accion</th>
		                <th scope="col">Fecha</th>
		                <th scope="col">Estado</th>
	                    <th scope="col">Ver</th>
		            </tr>
		        </thead>
		        <tbody>
	            @foreach ($fichas_history as $ficha_pending)
				    <tr>
				      <td>@if($ficha_pending->model){{ $ficha_pending->model->cod_ficha }}@else{{ isset($ficha_pending->deferred_actions) ? $ficha_pending->deferred_actions['setNewCodFicha'][0] : '' }}@endif</td>
				      <td>{{ isset($ficha_pending->model) ? $ficha_pending->model->denominacion : (isset($ficha_pending->fields['denominacion']) ? $ficha_pending->fields['denominacion'] : '') }}</td>
				      <td>@isset($ficha_pending->user){{ $ficha_pending->user->full_name }}@endisset</a></td>
				      <td>{{ __('carta.' . $ficha_pending->action) }}</td>
				      <td>{{ $ficha_pending->created_at->format('Y/m/d H:i') }}</td>
				      <td>
						@if ($ficha_pending->status == \App\ModerableRecord::APPROVED)
							<span class="text-success">Aceptado</span>
						@elseif ($ficha_pending->status == \App\ModerableRecord::REJECTED)
							<span class="text-danger">Rechazado</span>
						@endif
				      </td>
			      	  <td>{{ route('admin.historial.show', $ficha_pending->id) }}</td>
				    </tr>
			    @endforeach
	           </tbody>
	       </table>
		</div>
	</div>
</div>
@endsection

@push('scripts')
	@include('shared_partials.fichas.moderation.datatable', ['table_id' => 'history-table', 'column' => 6])
@endpush

