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
				<p><h3>@lang('carta.config.localidad')</h3></p>
				@include('admin.config.partials.info-pagination', ['models' => $localidades])
			</div>
		</div>
		
		<div class="row mb-3">
			<div class="col-lg-2 mr-auto">
				<button type="button" class="btn btn-outline-secondary btn-block" data-toggle="modal" data-target="#storeModal">Añadir</button>
			</div>
		</div>

		{{-- Filtros de búsqueda --}}
		<form action="{{ route('admin.localidades.index') }}" >
			<div class="form-group row mb-3">
				<div class="col-lg-3">
					<select2 id="isla_id_filter" :options="islas" :allowclear="allow" :placeholder="placeholder_isla" name="isla_id" v-model="isla" @input="getMunicipios"></select2>
				</div>

				<div class="col-lg-3">
					<select2 id="municipio_id_filter" :options="municipios" :allowclear="allow" :placeholder="placeholder_municipio" name="municipio_id" v-model="municipio"></select2>
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

		@if(isset($localidades) && $localidades->isNotEmpty())
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
						@foreach ($localidades as $localidad)
						<tr>
							<td scope="row">
								<strong>{{ $localidad->nombre }}</strong>
								<br>
								{{ $localidad->isla->nombre }}, {{ $localidad->municipio->nombre }}
							</td>
							<td>
								<div class="row">
									<div class="col-lg-4">
										<button v-on:click="update('{{ route('admin.localidades.update', $localidad->id) }}', '{{ $localidad->nombre }}')" class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#updateModal">Editar</button>
										<br>
									</div>
									<div class="col-lg-4">
										<form v-on:submit.prevent="confirmDel({{ $localidad->id }})" id="delForm_{{ $localidad->id }}" action="{{ route('admin.localidades.destroy', $localidad->id) }}" method="post">
											@csrf
											@method('DELETE')
											<input type="hidden" name="isla_id" value="{{ $isla }}">
											<input type="hidden" name="municipio_id" value="{{ $municipio }}">
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
				{{ $localidades->appends(['search' => $search, 'isla_id' => $isla, 'municipio_id' => $municipio])->links() }}
			</div>
		</div>
		@else
			<div class="row">
				<div class="col">
					<p>No se han encontrado localidades.</p>
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
			<select2 id="isla_id_store" :options="islas" :allowclear="allow" :placeholder="placeholder_isla" name="isla_id" @input="getMunicipiosModal" v-model="isla_modal"></select2>
		</div>
		<div class="form-group">
			<select2 id="municipio_id_store" :options="municipios_modal" :allowclear="allow" :placeholder="placeholder_municipio" name="municipio_id"></select2>
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
			<input type="hidden" name="isla_id" value="{{ $municipio }}">
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
			storeRoute: '{{ route('admin.localidades.store') }}',
			updateRoute: '',
			nombre: '',
			isla: '{{ $isla }}',
			isla_modal: '',
			islas: {!! $islas->toJson() !!},
			municipio: '{{ $municipio }}',
			municipios: @if (isset($municipios)) {!! $municipios->toJson() !!} @else [] @endif,
			municipios_modal: [],
			placeholder_isla: "Seleccione una isla",
			placeholder_municipio: "Seleccione un municipio",
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
			getMunicipios() {
				if (this.isla) {
					Vue.axios.get('/municipios/'+this.isla)
						.then((response) => {
							this.municipios = response.data;
						})
				} else {
					this.municipios = [];
				}
			},
			getMunicipiosModal() {
				if (this.isla_modal) {
					Vue.axios.get('/municipios/'+this.isla_modal)
						.then((response) => {
							this.municipios_modal = response.data;
						})
				} else {
					this.municipios_modal = [];
				}
			}
		}
	})
</script>
@endpush