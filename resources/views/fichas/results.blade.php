@extends('layouts.public')

@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('carta.breadcrumb_home')</a></li>
    <li class="breadcrumb-item active" aria-current="page">@lang('carta.breadcrumb_resultados')</li>
  </ol>
</nav>

<p>{{ trans_choice('carta.resultados_busqueda', $fichas->total(), ['total' => $fichas->total()]) }}</p>
@isset($params['query'])<p>Palabras clave: "{{ $params['query'] }}"</p>@endisset
@isset($params['latitud'])<p>Por proximimidad geográfica: latitud ({{ $params['latitud'] }}), longitud ({{ $params['longitud'] }}), radio ({{ $params['radio'] }} m)</p>@endisset
@isset($params['municipio'])<p>Municipio = {{ App\Municipio::find($params['municipio'])->nombre }}</p>@endisset
@isset($params['actividad'])<p>Actividad = {{ App\Actividad::find($params['actividad'])->nombre }}</p>@endisset
@isset($params['grupo'])<p>Grupo = {{ App\Grupo::find($params['grupo'])->nombre }}</p>@endisset
@isset($params['tipo'])<p>Tipo = {{ App\Tipo::find($params['tipo'])->nombre }}</p>@endisset

@if(isset($fichas) && $fichas->isNotEmpty())

	<p>@lang('carta.resultados_busqueda_info1')</p>
	<p>@lang('carta.resultados_busqueda_info2')</p>

	<div class="row mt-5">

		@foreach ($fichas as $ficha)
			<div class="col-lg-6">
				<div class="ficha">
					<div class="row">
						<div class="col-lg-3">
							<a href="{{ route('fichas.show', $ficha->cod_ficha) }}">
								<img src="{{ url('fotos/' . $ficha->fotos['fotos'][0]) }}" class="img-fluid">
							</a>
						</div>
						<div class="col-lg-8">
							<p>Nº {{ $ficha->cod_ficha }}, <strong><a href="{{ route('fichas.show', $ficha->cod_ficha) }}">{{ $ficha->denominacion }}</a></strong>
							@isset($ficha->toponimias){{ $ficha->toponimias }},@endisset @isset($ficha->localidad){{ $ficha->localidad->nombre }}@endisset{{ isset($ficha->municipio) ? ', ' . $ficha->municipio->nombre : '' }}</p>
						</div>
						<div class="col-lg-1 text-center">
							<i class="fas fa-map-marker-alt"></i>
						</div>
					</div>
				</div>
				<br>
			</div>
		@endforeach

	</div>

	<div id="fichas-results">
        <div class="col-md-12 col-lg-4">
            <a class="confirmation" href="#" v-on:click.prevent="confirmDownload"> Descargar listado </a>
        </div>
        <div class="col-md-12 col-lg-4">
            <a href="{{ route('fichas.download.kml', request()->query())  }}"> Descargar kml </a>
        </div>
	</div>

	<div class="row justify-content-center">
		<div class="col-lg-auto">
			{{ $fichas->appends($params)->links() }}
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-lg-12 map-results">
			@isset($map)
			{!! $map !!}
			@endisset
		</div>
	</div>

@endif

@endsection

@push('scripts')
<script>
	var app = new Vue({
		el: '#fichas-results',
		data: {
			listadoHref: "{{ route('fichas.download.results', request()->query())  }}",
		},
		methods: {
			confirmDownload: function () {
				@if($fichas->total() > config('carta.maxFichasDownloadWarning'))
					// Pop-up de confirmación sweetalert
					swal({
					  title: '@lang('carta.alert_title')',
					  text: "@lang('carta.alert_download_text', ['attribute' => config('carta.maxFichasDownloadWarning')])",
					  type: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '@lang('carta.alert_cancel_button_text')',
					  confirmButtonText: 'Si, descargar'
					}).then((result) => {
					  if (result.value) {
					    var parser = new DOMParser;
					    var dom = parser.parseFromString(
					        '<!doctype html><body>' + this.listadoHref,
					        'text/html');
					    var decodedString = dom.body.textContent;
					    window.open(decodedString);
					  }
					})
				@else
					var parser = new DOMParser;
					var dom = parser.parseFromString(
					    '<!doctype html><body>' + this.listadoHref,
					    'text/html');
					var decodedString = dom.body.textContent;
					window.open(decodedString);
				@endif
			},
		}
	})
</script>
@endpush

