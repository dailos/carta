@extends('layouts.admin')

@section('content')
<div id="config_admin">
	<div class="container">
		<div class="row mb-3">
			<div class="col-lg-2 col-md-2">
				<h3>CONFIGURACIÓN</h3>
			</div>

		</div>

		<div class="row">
			<div class="col-lg-4 col-md-2 ">
				<div class="input-group mb-3">
					@include('admin.config.partials.menu')
				</div>
			</div>
		</div>
	</div>	

	<div class="container">
		@isset($type)
			<div class="row">
				<div class="col-lg-8">
					<p><h3>@lang('carta.config.' . $type)</h3></p>
					@include('admin.config.partials.info-pagination', ['models' => $models])
				</div>
			</div>
			
			<div class="row mb-3">
				<div class="col-lg-2 mr-auto">
					<button type="button" class="btn btn-outline-secondary btn-block" data-toggle="modal" data-target="#storeModal">Añadir</button>
				</div>
			</div>

			@include('admin.config.partials.filters')
			
		@endisset

		@include('shared_partials.errors')

		@isset($models)
			@if($models->isNotEmpty())
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
							@foreach ($models as $model)
							<tr>
								<td scope="row">
									<strong>{{ $model->nombre }}</strong>
								</td>
								<td>
									<div class="row">
										<div class="col-lg-4">
											<button v-on:click="update('{{ route('admin.configuracion.update', $model->id) }}', '{{ $model->nombre }}')" class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#updateModal">Editar</button>
											<br>
										</div>
										<div class="col-lg-4">
											<form v-on:submit.prevent="confirmDel({{ $model->id }})" id="delForm_{{ $model->id }}" action="{{ route('admin.configuracion.destroy', $model->id) }}" method="post">
												@csrf
												@method('DELETE')
												<input type="hidden" name="type" value="{{ $type }}">
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
					{{ $models->appends(['type' => $type, 'search' => $search])->links() }}
				</div>
			</div>
			@else
				<div class="row">
					<div class="col">
						<p>No hay elementos registrados para este tipo.</p>
					</div>
				</div>
			@endif
		@endisset
	</div>

	@modalsave([
		'id' => 'storeModal',
		'title' => 'Introduza un nombre',
		'route' => 'storeRoute'
		])
		<div class="form-group mb-0">
			<input type="hidden" name="type" value="{{ $type }}">
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
			<input type="hidden" name="type" value="{{ $type }}">
			<input type="hidden" name="search" value="{{ $search }}">
			<input v-model="nombre" type="text" class="form-control" name="nombre" required>
		</div>
	@endmodalsave

</div>

@endsection

@push('scripts')
<script>
	var app = new Vue({
		el: '#config_admin',
		data: {
			storeRoute: '{{ route('admin.configuracion.store') }}',
			updateRoute: '',
			nombre: '',
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