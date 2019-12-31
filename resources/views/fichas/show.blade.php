@extends('layouts.public')

@section('metadescription')
    {{ $ficha->denominacion }}{{ isset($ficha->actividad) ? (', ' . $ficha->actividad->nombre) : '' }}{{ isset($ficha->grupo) ? (', ' . $ficha->grupo->nombre) : '' }}
@endsection

@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Carta etnográfica de Gran Canaria</a></li>
    @if(null !== session('query'))
    <li class="breadcrumb-item"><a href="{{ route('fichas.search', ['query' => session('query'), 'page' => session('page')]) }}">Resultados de la búsqueda</a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">Ficha</li>
  </ol>
</nav>

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-lg-10">
                <h3>{{ $ficha->denominacion }}</h3>
                <h5>{{ sprintf("%05d", $ficha->cod_ficha) }} - {{ $ficha->denominacion }}@isset($ficha->actividad){{ ', '
                . $ficha->actividad->nombre }}@endisset{{ isset($ficha->grupo) ? (', ' . $ficha->grupo->nombre) : '' }}</h5>
            </div>
            <div class="col-lg-2 ">
                <a href="{{ route('fichas.download', $ficha->cod_ficha) }}" class="btn btn-primary">Descargar PDF</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-4">
            <div class="col-lg-5">
                <h5>DATOS GENERALES</h5>
                <div class="custom-border-top pt-2">
                    <div class="mb-2">
                        <h6 class="titulo d-inline">CÓDIGO: </h6><p class="d-inline">{{ sprintf("%05d", $ficha->cod_ficha) }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">ACTIVIDAD: </h6><p class="d-inline">@isset($ficha->actividad){{ $ficha->actividad->nombre }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">GRUPO / TIPO: </h6><p class="d-inline">{{ $ficha->grupo_tipo }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">ANTIGÜEDAD: </h6><p class="d-inline">@isset($ficha->antiguedad){{ $ficha->antiguedad->nombre }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">SUPERFICIE: </h6><p class="d-inline">@isset($ficha->superficie){!! $ficha->superficie . ' m<sup>2</sup>' !!}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">USO ACTUAL: </h6><p class="d-inline">@isset($ficha->uso_actual){{ $ficha->uso_actual->nombre }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">D.G.P.H: </h6><p class="d-inline">{{ $ficha->numero_dgph }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                @include('shared_partials.fichas.show.fotos')
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 mt-4">
                <h5>ESTADO</h5>
                <div class="custom-border-top pt-2">
                    <div class="mb-2">
                        <h6 class="titulo d-inline">DESTRUCCIÓN POR OBRAS: </h6><p class="d-inline">{{ $ficha->dest_obras_text }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">SAQUEOS: </h6><p class="d-inline">{{ $ficha->saqueos_text }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">ALTERACIONES NATURALES: </h6><p class="d-inline">{{ $ficha->alte_naturales_text }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">OTRAS ALTERACIONES: </h6><p class="d-inline">{{ $ficha->otras_text }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">ESTADO: </h6><p class="d-inline">@isset($ficha->estado){{ $ficha->estado->nombre }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">FRAGILIDAD: </h6><p class="d-inline">@isset($ficha->fragilidad){{ $ficha->fragilidad->nombre }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">VALOR CIENTÍFICO: </h6><p class="d-inline">@isset($ficha->valor_cientifico){{ $ficha->valor_cientifico->nombre }}@endisset </p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">PROPIEDAD: </h6><p class="d-inline">@isset($ficha->propiedad){{ $ficha->propiedad->nombre }}@endisset	</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">CLASIFICACIÓN DEL SUELO: </h6><p class="d-inline">@isset($ficha->clasificacion_suelo){{ $ficha->clasificacion_suelo->nombre }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">CALIFICACIÓN DEL SUELO: </h6><p class="d-inline">@isset($ficha->calificacion_suelo){{ $ficha->calificacion_suelo->nombre }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">NIVEL DE PROTECCIÓN: </h6><p class="d-inline">{{ $ficha->nivel_proteccion }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">OBSERVACIONES DE ESTADO: </h6><p class="d-inline">{{ $ficha->obs_estado }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 mt-4">
                <h5>LOCALIZACION</h5>
                <div class="custom-border-top pt-2">
                    <div class="mb-2">
                        <h6 class="titulo d-inline">DIRECCIÓN: </h6><p class="d-inline">{{ $ficha->direccion }} {{ $ficha->cod_postal . ' ' }}- @isset($ficha->localidad){{ $ficha->localidad->nombre . ' ' }}@endisset @isset($ficha->municipio){{ $ficha->municipio->nombre }}@endisset</p>
                    </div>

                    <div class="mb-2">
                        <h6 class="titulo d-inline">UTM CUADRANTE: </h6><p class="d-inline">@isset($ficha->zona_UTM){{ $ficha->zona_UTM }} X: {{ $ficha->X }} Y: {{ $ficha->Y }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">ALTITUD: </h6><p class="d-inline">@isset($ficha->altitud){{ $ficha->altitud . 'm' }}@endisset</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">TOPONIMIAS: </h6><p class="d-inline">{{ $ficha->toponimias }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">CARTOGRAFÍA: </h6><p class="d-inline">{{ $ficha->cartografia }}</p>
                    </div>
                    @isset($map)
                    <div class="map-show">
                        {!! $map !!}
                    </div>
                    @endisset
                </div>
            </div>
        </div>
        @isset($ficha->documentacion)
        <div class="row mt-4">
            <div class="col-lg-12">
                <h5>DOCUMENTACIÓN</h5>
                <div class="custom-border-top pt-2">
                     <div class="mb-2">
                         {{$ficha->documentacion}}
                     </div>
        {{-- 			<div class="mb-2">
                        <h6 class="titulo d-inline">LOCALIZACIÓN: </h6><p id="localizacion" class="d-inline">{{ $ficha->obs_localizacion }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">HISTORIA: </h6><p class="d-inline">{{ $ficha->historia }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">DESCRIPCIÓN: </h6><p class="d-inline">{{ $ficha->descripcion }}</p>
                    </div> --}}
                </div>
            </div>
        </div>
        @endisset

        <div class="row mt-4">
            <div class="col-lg-12">
                <h5>OBSERVACIONES</h5>
                <div class="custom-border-top pt-2">
                    <div class="mb-2">
                        <h6 class="titulo d-inline">LOCALIZACIÓN: </h6><p id="localizacion" class="d-inline">{{ $ficha->obs_localizacion }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">HISTORIA: </h6><p class="d-inline">{{ $ficha->historia }}</p>
                    </div>
                    <div class="mb-2">
                        <h6 class="titulo d-inline">DESCRIPCIÓN: </h6><p class="d-inline">{{ $ficha->descripcion }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($ficha->enlaces) || isset($ficha->multimedia))
            <div class="row mt-4">
                <div class="col-lg-12">
                    <h5>INFORMACIÓN ADICIONAL</h5>
                    <div class="custom-border-top pt-2">
                        @isset($ficha->enlaces)
                        <div class="mb-2">
                            <h6 class="titulo">ENLACES:</h6>
                            <ul>
                            @foreach ($ficha->enlaces as $enlace)
                                <li><a href="{{ $enlace['url'] }}">@if($enlace['texto'])
                                    {{ $enlace['texto'] }}
                                    @else
                                    {{ $enlace['url'] }}
                                    @endif</a></li>
                            @endforeach
                            </ul>
                        </div>
                        @endisset
                        @isset($ficha->multimedia)
                        <div>
                            <h6 class="titulo">VIDEOS: </h6>
                            @foreach ($ficha->multimedia as $multimedia)
                            <div class="my-2">
                                {!! LaravelVideoEmbed::parse($multimedia['url']) !!}
                                @if($multimedia['descripcion'])
                                <p>{{ $multimedia['descripcion'] }}</p>
                                @endif
                                @if (!$loop->last)
                                <br>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
