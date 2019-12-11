@extends('layouts.admin')

@section('content')
<div id="app">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-md-2 ">
				<h3>CONFIGURACIÓN</h3>
			</div>

		</div>
		<br>
		<div class="row">
			<div class="col-lg-4 col-md-2 ">
				<div class="input-group mb-3">
					@include('admin.config.partials.menu')
				</div>
			</div>
		</div>
		<br>
	</div>	

	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<p><h3>@lang('carta.config.municipio')</h3></p>
				@include('admin.config.partials.info-pagination', ['models' => $municipios])
			</div>
		</div>
		
		<div class="row mb-3">
			<div class="col-lg-2 mr-auto">
				<button type="button" class="btn btn-outline-secondary btn-block" data-toggle="modal" data-target="#storeModal">Añadir</button>
			</div>
		</div>

		{{-- Filtros de búsqueda --}}
		<form action="{{ route('admin.municipios.index') }}" >
			<div class="form-group row mb-3">
				<div class="col-lg-3">
					<select2 id="isla_id_filter" :options="islas" :allowclear="allow" :placeholder="placeholder_isla" name="isla_id" v-model="isla"></select2>
				</div>

				<div class="col-lg-3">
					<input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar" aria-label="Buscar" value="{{ $search }}">
				</div>

				<div class="col-lg-2">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
				</div>
			</div>
		</form>

		@include('shared_partials.errors')

		@if(isset($municipios) && $municipios->isNotEmpty())
		<div class="row">
			<div class="col-lg-12 table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">Nombre</th>
							<th scope="col">Acciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($municipios as $municipio)
						<tr>
							<td scope="row">
								<strong>{{ $municipio->nombre }}</strong>
								<br>
								{{ $municipio->isla->nombre }}
							</td>
							<td>
								<div class="row">
									<div class="col-lg-4">
										<button v-on:click="update('{{ route('admin.municipios.update', $municipio->id) }}', '{{ $municipio->nombre }}')" class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#updateModal">Editar</button>
										<br>
									</div>
									<div class="col-lg-4">
										<form v-on:submit.prevent="confirmDel({{ $municipio->id }})" id="delForm_{{ $municipio->id }}" action="{{ route('admin.municipios.destroy', $municipio->id) }}" method="post">
											@csrf
											@method('DELETE')
											<input type="hidden" name="isla_id" value="{{ $isla }}">
											<input type="hidden" name="search" value="{{ $search }}">
											<button class="btn btn-outline-danger btn-block" type="submit">Eliminar</button>
										</form>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col">
				{{ $municipios->appends(['search' => $search, 'isla_id' => $isla])->links() }}
			</div>
		</div>
		@else
			<div class="row">
				<div class="col">
					<p>No se han encontrado municipios.</p>
				</div>
			</div>
		@endif
	</div>

	@modalsave([
		'id' => 'storeModal',
		'title' => 'Introduza un nombre',
		'route' => 'storeRoute'
		])
		<div class="form-group">
			<select2 id="isla_id" :options="islas" :allowclear="allow" :placeholder="placeholder_isla" name="isla_id"></select2>
		</div>
		<div class="form-group mb-0">
			<input type="hidden" name="search" value="{{ $search }}">
			<input type="text" class="form-control" name="nombre" required>
		</div>
	@endmodalsave

	@modalsave([
		'id' => 'updateModal',
		'title' => 'Modificar nombre',
		'route' => 'updateRoute'
		])
		<div class="form-group mb-0">
			@method('PUT')
			<input type="hidden" name="isla_id" value="{{ $isla }}">
			<input type="hidden" name="search" value="{{ $search }}">
			<input v-model="nombre" type="text" class="form-control" name="nombre" required>
		</div>
	@endmodalsave
</div>

@endsection

@push('scripts')
<script>
	var app = new Vue({
		el: '#app',
		data: {
			storeRoute: '{{ route('admin.municipios.store') }}',
			updateRoute: '',
			nombre: '',
			isla: '{{ $isla }}',
			islas: {!! $islas->toJson() !!},
			placeholder_isla: "Seleccione una isla",
			allow: true,
		},
		methods: {
			update: function (route, value) {
				this.updateRoute = route
				this.nombre = value
			},
			confirmDel: function (id) {
				// Pop-up de confirmación sweetalert
				swal({
				  title: '@lang('carta.alert_title')',
				  text: "@lang('carta.alert_text')",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '@lang('carta.alert_cancel_button_text')',
				  confirmButtonText: '@lang('carta.alert_confirm_button_text')'
				}).then((result) => {
				  if (result.value) {
				    $('#delForm_' + id).submit();
				  }
				})
			},
		}
	})
</script>
@endpush