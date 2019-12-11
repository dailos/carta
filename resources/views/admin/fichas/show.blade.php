@extends('layouts.admin')

@section('content')
<div class="container">
	<div id="show_ficha" class="row mb-2">
		<div class="col-lg-2 col-md-2 col-12">
			<h3>FICHA</h3>
		</div>
		<div class="col-lg-2 col-md-2 col-12 mb-2">
			<a href="{{ route('admin.fichas.edit', $ficha->id) }}" class="btn btn-outline-secondary btn-block">Editar</a>
		</div>
		<div class="col-lg-2 col-md-2 col-12 mb-2">
			<form v-on:submit.prevent="confirmDel" id="delForm" action="{{ route('admin.fichas.destroy', $ficha->id) }}" method="post">
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-outline-danger btn-block">Eliminar</button>
			</form>
		</div>	
		<div class="col-lg-2 col-md-2 col-12 mb-2">
			<a class="btn btn-outline-secondary btn-block" href="{{ route('fichas.download', $ficha->cod_ficha) }}" class="btn btn-block">Imprimir</a>
		</div>
	</div>
{{-- 
	<div class="row mb-2">
		<div class="col-lg-12 text-right">
			<i class="fas fa-angle-left"></i> Ficha anterior | Ficha siguiente <i class="fas fa-angle-right"></i>
		</div>
	</div>
 --}}
	<div class="row align-items-center mb-5">
		<div class="col-lg-5 py-2">
			@include('shared_partials.fichas.show.fotos')
		</div>
		@isset($map)
		<div class="col-lg-7 py-2 map-show">
			{!! $map !!}
		</div>
		@endisset
	</div>

	@include('shared_partials.fichas.show.datos')

</div>
@endsection

@push('scripts')
<script>
	var app = new Vue({
		el: '#show_ficha',
		data: {
		},
		methods: {
			confirmDel: function () {
				// Pop-up de confirmación sweetalert
				swal({
				  title: '@lang('carta.alert_title')',
				  text: "@lang('carta.alert_text') @if($ficha->moderableRecords()->pending()->get()->isNotEmpty()) @lang('carta.alert_fichas_asociadas') @endif",
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