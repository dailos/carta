@extends('layouts.admin')

@section('content')
	<div id="users_conf" class="container">
		<div class="row">
			<div class="col-lg-4 col-md-12 col-12">
				<h3>GESTIÓN DE USUARIOS</h3>
			</div>
			<div class="col-lg-2 col-md-6 col-12">
				<a href="{{ route('admin.users.create') }}" class="btn btn-outline-secondary btn-block">Crear usuario</a>
				<br>
			</div>
		</div>

		<br>

		@if($users && $users->isNotEmpty())
			<div class="row">
			@foreach ($users as $user)
				<div class="col-lg-4 col-md-6 col-12">
					<div class="card">
					  <div class="card-body">
					  	<div class="row">
					  		<div class="col-lg-8 col-8">
					  			<a href="{{ route('admin.users.show', $user->id) }}">{{ $user->full_name }}</a><br>
					  			{{ ucfirst(__('carta.' . $user->roles->first()->name)) }}
					  		</div>
					  		<div class="col-lg-2 col-2">
					  			<form v-on:submit.prevent="confirmDel" id="delForm" action="{{ route('admin.users.destroy', $user->id) }}" method="post">
					  				@csrf
					  				@method('DELETE')
					  				<button type="submit" class="btn btn-link p-0 m-0" title="Eliminar usuario"><i class="fas fa-trash fa-2x" style="color:red"></i></button>
					  			</form>
					  		</div>
					  		<div class="col-lg-2 col-2">	
					  			<a href="{{ route('admin.users.edit', $user->id) }}"><i class="fas fa-pencil-alt fa-2x" title="Editar usuario"></i></a>
					  		</div>
					  	</div>
					  </div>
					</div>
				</div>
			@endforeach
			</div>
		@else

		<div class="row">
			<div class="col">No hay otros usuarios registrados</div>
		</div>

		@endif

	</div>

@endsection

@push('scripts')
<script>
    $(".card2").click(function() {
        window.location = $(this).parent().data("href");
    });
</script>
@endpush

@push('scripts')
<script>
	var app = new Vue({
		el: '#users_conf',
		data: {
		},
		methods: {
			confirmDel: function () {
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
				    $('#delForm').submit();
				  }
				})
			},
		}
	})
</script>
@endpush

