@extends('layouts.admin')

@section('content')
<div id="history" class="container">
	<div class="row mb-5">
		<div class="col-lg-4 col-md-5 col-12 mb-2">
			<h3 class="mb-0">{{ strtoupper(__('carta.' . $moderableRecord->action)) }} FICHA</h3>
		</div>

		<div class="col-lg-4 col-md-2 col-12 mb-4">
			<span>Fecha petición: {{ $moderableRecord->created_at->format('Y/m/d H:i') }}</span>
		</div>

		<div class="col-lg-2 col-md-2 col-12 mb-4">
			<a href="{{ route('admin.historial.index') }}" class="btn btn-outline-primary btn-block">Volver</a>
		</div>
		<div class="col-lg-2 col-md-2 col-12">
			<form v-on:submit.prevent="confirmDel" id="delForm" action="{{ route('admin.historial.destroy', $moderableRecord->id) }}" method="post">
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-outline-danger btn-block">Eliminar</button>
			</form>
		</div>
	</div>

	@include('shared_partials.fichas.moderation.datos')

</div>
@endsection

@push('scripts')
<script>
	var app = new Vue({
		el: '#history',
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
