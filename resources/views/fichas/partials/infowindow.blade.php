<strong>nº {{ $ficha->cod_ficha }}</strong>
<h5>{{ $ficha->denominacion }}</h5>
<p>{{ $tipologias }}</p>
<p>{{ $descripcion }}... <a href="{{ route('fichas.show', $ficha->cod_ficha) }}">ver mas</a></p>
