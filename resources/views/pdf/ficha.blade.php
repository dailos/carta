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
		<div style="float: right;">
			<img src="{{ asset('images/logo.png') }}" alt="Logo Cabildo Gran Canaria + Fedac" height="75px">			
		</div>
		
		<h1>INVENTARIO PATRIMONIO ETNOGRÁFICO</h1>

		<div class="columna">
			<label class="titulo">DATOS ETNOGRÁFICOS</label>
			<div class="caja">
				<p class="texto"><label class="subtitulo">CÓDIGO FICHA: &nbsp;</label> {{ sprintf("%05d", $ficha->cod_ficha) }}</p>
                <p class="texto"><label class="subtitulo">ENLACE: &nbsp;</label>
                    <a href="{{url(route('fichas.show', ['cod_ficha' => $ficha->cod_ficha])) }}">
                        {{url(route('fichas.show', ['cod_ficha' => $ficha->cod_ficha])) }}
                    </a></p>
				<p class="texto"><label class="subtitulo">NOMBRE: &nbsp;</label> {{ $ficha->denominacion }}</p>
				<p class="texto"><label class="subtitulo">ACTIVIDAD: &nbsp;</label> @isset($ficha->actividad){{ $ficha->actividad->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">GRUPO / TIPO: &nbsp;</label> {{ $ficha->grupo_tipo }}</p>
				<p class="texto"><label class="subtitulo">D.G.P.H: &nbsp;</label> {{ $ficha->numero_dgph }}</p>
			</div>

			<label class="titulo">LOCALIZACIÓN</label>
			<div class="caja">
				<p class="texto"><label class="subtitulo">ISLA: &nbsp;</label> @isset($ficha->isla){{ $ficha->isla->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">MUNICIPIO: &nbsp;</label> @isset($ficha->municipio){{ $ficha->municipio->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">LOCALIDAD: &nbsp;</label> @isset($ficha->localidad){{ $ficha->localidad->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">DIRECCIÓN: &nbsp;</label> {{ $ficha->direccion }}</p>
				<p class="texto"><label class="subtitulo">CÓDIGO POSTAL: &nbsp;</label> {{ $ficha->cod_postal }}</p>
				<p class="texto"><label class="subtitulo">TELÉFONO: &nbsp;</label> {{ $ficha->telefono }}</p>
				<p class="texto"><label class="subtitulo">UMT (CUADRANTE-X-Y): &nbsp;</label> @isset($ficha->zona_UTM){{ $ficha->zona_UTM }} - {{ $ficha->X }} - {{ $ficha->Y }}@endisset</p>
				<p class="texto"><label class="subtitulo">ALTITUD: &nbsp;</label> @isset($ficha->altitud){{ $ficha->altitud . 'm' }}@endisset</p>
				<p class="texto"><label class="subtitulo">TOPONIMIA: &nbsp;</label> {{ $ficha->toponimias }}</p>
				<p class="texto"><label class="subtitulo">CARTOGRAFIA: &nbsp;</label> {{ $ficha->cartografia }}</p>
				<p class="texto"><label class="subtitulo">OBSERVACIONES: &nbsp;</label> {{ $ficha->obs_localizacion }}</p>
			</div>

			<div class="mapa">
				<img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $ficha->latitud }},{{ $ficha->longitud }}&zoom={{ config('carta.pdfZoom') }}&size=475x300&maptype=roadmap
&markers={{ $ficha->latitud }},{{ $ficha->longitud }}
&key={{ env('GOOGLE_API_KEY') }}" alt="Mapa localización">
			</div>
		</div>

		<div class="columna">
			<label class="titulo">ESTADO DE CONSERVACIÓN</label>
			<div class="caja">
				<p class="texto"><label class="subtitulo">DESTRUCCIÓN POR OBRAS: &nbsp;</label> {{ $ficha->dest_obras_text }}</p>
				<p class="texto"><label class="subtitulo">SAQUEOS: &nbsp;</label> {{ $ficha->saqueos_text }}</p>
				<p class="texto"><label class="subtitulo">ALTERACIONES NATURALES: &nbsp;</label> {{ $ficha->alte_naturales_text }}</p>
				<p class="texto"><label class="subtitulo">OTRAS ALTERACIONES: &nbsp;</label> {{ $ficha->otras_text }}</p>
				<p class="texto"><label class="subtitulo">ESTADO DE CONSERVACIÓN: &nbsp;</label> @isset($ficha->estado){{ $ficha->estado->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">FRAGILIDAD: &nbsp;</label> @isset($ficha->fragilidad){{ $ficha->fragilidad->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">VALOR CIENTÍFICO PATRIMONIAL: &nbsp;</label> @isset($ficha->valor_cientifico){{ $ficha->valor_cientifico->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">OBSERVACIONES: &nbsp;</label> {{ $ficha->obs_estado }}</p>
			</div>

			<label class="titulo">DATOS ASOCIADOS AL BIEN ETNOGRÁFICO</label>
			<div class="caja">
				<p class="texto"><label class="subtitulo">FECHA DE CONSTRUCCIÓN: &nbsp;</label> {{ $ficha->fecha_construccion }}</p>
				<p class="texto"><label class="subtitulo">ANTIGÜEDAD: &nbsp;</label> @isset($ficha->antiguedad){{ $ficha->antiguedad->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">HISTORIA: &nbsp;</label> {{ $ficha->historia }}</p>
				<p class="texto"><label class="subtitulo">USO ACTUAL: &nbsp;</label> @isset($ficha->uso_actual){{ $ficha->uso_actual->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">SUPERFICIE: &nbsp;</label> @isset($ficha->superficie){!! $ficha->superficie . ' m<sup>2</sup>' !!}@endisset</p>
				<p class="texto"><label class="subtitulo">DESCRIPCIÓN: &nbsp;</label> {{ $ficha->descripcion }}</p>
			</div>

			<label class="titulo">DOCUMENTACIÓN</label>
			<div class="caja">
				<p class="texto">{{ $ficha->documentacion }}</p>
			</div>

		</div>

		<div class="columna">
			<label class="titulo">SITUACIÓN JURIDICO - ADMINISTRATIVA</label>
			<div class="caja">
				<p class="texto"><label class="subtitulo">PROPIEDAD: &nbsp;</label> @isset($ficha->propiedad){{ $ficha->propiedad->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">DECLARACIÓN B.I.C: &nbsp;</label> {{ $ficha->declaracion_BIC_text }}</p>
				<p class="texto"><label class="subtitulo">CLASIFICACIÓN DEL SUELO: &nbsp;</label> @isset($ficha->clasificacion_suelo){{ $ficha->clasificacion_suelo->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">CALIFICACIÓN DEL SUELO: &nbsp;</label> @isset($ficha->calificacion_suelo){{ $ficha->calificacion_suelo->nombre }}@endisset</p>
				<p class="texto"><label class="subtitulo">NIVEL DE PROTECCIÓN: &nbsp;</label> {{ $ficha->nivel_proteccion }}</p>
				<p class="texto"><label class="subtitulo">INTERVENCIONES PERMITIDAS: &nbsp;</label> {{ $ficha->intervenciones }}</p>
				<p class="texto"><label class="subtitulo">GRADO DE PROTECCIÓN: &nbsp;</label> @isset($ficha->grado_proteccion){{ $ficha->grado_proteccion->nombre }}@endisset</p>
			</div>

			<label class="titulo">SUGERENCIAS</label>
			<div class="caja">
				@if($ficha->obs_generales)
				<p class="texto">{{ $ficha->sugerencias }}</p>
				@else
				<p class="vacio">&nbsp;</p>
				@endif
			</div>

			<label class="titulo">OBSERVACIONES</label>
			<div class="caja">
				@if($ficha->obs_generales)
				<p class="texto">{{ $ficha->obs_generales }}</p>
				@else
				<p class="vacio">&nbsp;</p>
				@endif
			</div>
		
			<label class="titulo">FOTOGRAFÍAS</label>
			<div class="caja">
				@isset($ficha->fotos['fotos'])
					<p class="texto"><img class="foto" src="{{ url('fotos/' . $ficha->fotos['fotos'][0]) }}" alt="Foto del bien"></p>
				@endisset
			</div>
		</div> <!-- END COLUMNA -->
	</div> <!-- END CONTAINER -->
</body>
</html>	
