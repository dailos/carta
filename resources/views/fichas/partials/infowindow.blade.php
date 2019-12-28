<strong>nº {{ $ficha->cod_ficha }}</strong>
<h5>{{ $ficha->denominacion }}</h5>
@isset($ficha->fotos['fotos'])
    @foreach ($ficha->fotos['fotos'] as $id)
        @if ($loop->first)
            <div>
                <img class="d-block w-100" src="{{ url('fotos/' . $id) }}" alt="First slide">
            </div>
        @endif
    @endforeach
@endisset
<p>{{ $tipologias }}</p>
<p>{{ $descripcion }}... <a href="{{ route('fichas.show', $ficha->cod_ficha) }}">ver mas</a></p>
