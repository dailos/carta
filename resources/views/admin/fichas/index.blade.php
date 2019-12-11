@extends('layouts.admin')

@section('content')
<div class="container" id="fichas-list" v-cloak>
	<div class="row text-center mb-5">

		<div class="col-lg-2">
			<h3>FICHAS</h3>
		</div>

		<div class="col-lg-2 mb-2">
			<a href="{{ route('admin.fichas.create') }}" class="btn btn-outline-secondary btn-block">Nueva Ficha</a>
		</div>

		<div class="col-lg-2">
			@include('shared_partials.fichas.filtersmenu')
		</div>

	</div>

	@include('shared_partials.fichas.filtros')

	<div class="row">
		<div class="col-lg-12 table-responsive">
			<table class="table table-striped table-hover" id="fichas-table">
				<thead>
					<tr>
						<th scope="col">Imagen</th>
						<th scope="col">Cod. Ficha</th>
						<th scope="col">Denominación</th>
						<th scope="col">Actividad</th>
						<th scope="col">Grupo</th>
						<th scope="col">Tipo</th>
						<th scope="col">Municipio</th>
						<th scope="col">Localidad</th>
					</tr>
				</thead>

			</table>
		</div>
	</div>

</div>
@endsection

@push('scripts')
	@include('shared_partials.fichas.scripts.filtersdata', ['id' => 'fichas-list'])
@endpush

@push('scripts')
	@include('shared_partials.fichas.datatable', [
		'table_id' => 'fichas-table',
		'datatable_ajax' => $datatable_ajax,
		'datatable_view' => $datatable_view,
	])
@endpush
