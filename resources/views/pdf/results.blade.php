<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Generación de PDF</title>

	<link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body>
	<div class="container">
		<h1>Carta Etnongráfica de Gran Canaria</h1>

		<div>
			<strong>Consulta:</strong> Fecha: {{ \Carbon\Carbon::today()->format('d/m/Y') }}
			<p>
			@isset($params['latitud'])Por proximimidad geográfica: latitud ({{ $params['latitud'] }}), longitud ({{ $params['longitud'] }}), radio ({{ $params['radio'] }} m) @endisset
			@isset($params['municipio'])Municipio = {{ App\Municipio::find($params['municipio'])->nombre }} @endisset
			@isset($params['actividad'])Actividad = {{ App\Actividad::find($params['actividad'])->nombre }} @endisset
			@isset($params['grupo'])Grupo = {{ App\Grupo::find($params['grupo'])->nombre }} @endisset
			@isset($params['tipo'])Tipo = {{ App\Tipo::find($params['tipo'])->nombre }}@endisset
			@isset($params['query'])Palabras clave = "{{ $params['query'] }}"@endisset
			</p>
		</div>

		@foreach ($fichas as $ficha)
			<div>
				<div class="foto-listado">
					<img src="{{ url('fotos/' . $ficha->fotos['fotos'][0]) }}">
				</div>
				<div>
					<div>{{ strtoupper($ficha->denominacion) }}</div>
					<strong>Nº {{ $ficha->cod_ficha }} - </strong>
					<span class="texto-listado">
						@isset($ficha->toponimias){{ $ficha->toponimias }}, @endisset
						@isset($ficha->localidad){{ $ficha->localidad->nombre }}, @endisset
						@isset($ficha->municipio){{ $ficha->municipio->nombre }}, @endisset
						@isset($ficha->actividad){{ $ficha->actividad->nombre }}, @endisset
						@isset($ficha->grupo){{ $ficha->grupo->nombre }}, @endisset
						@isset($ficha->tipo){{ $ficha->tipo->nombre }}@endisset
					</span>
				</div>
			</div>
			<div class="clear-left"></div>

			@if ( $loop->iteration == 10 )
				<div class="page-break"></div>
			@elseif ( (($loop->iteration+2) % 12) === 0 ) 
				<div class="page-break"></div>
			@endif
		@endforeach

		
	</div> <!-- END CONTAINER -->
</body>
</html>	