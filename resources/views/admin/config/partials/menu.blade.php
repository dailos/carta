<div class="input-group-prepend">
	<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">¿Qué desea configurar?</button>
	<div class="dropdown-menu">
		@foreach (config('carta.configurable_models') as $type)
			@switch($type)
			    @case('municipio')
			        <a class="dropdown-item" href="{{ route('admin.municipios.index')}}">@lang('carta.config.' . $type)</a>
			        @break
				@case('localidad')
					<a class="dropdown-item" href="{{ route('admin.localidades.index')}}">@lang('carta.config.' . $type)</a>
			        @break
			    @default
			    	<a class="dropdown-item" href="{{ route('admin.configuracion.index', ['type' => $type]) }}">@lang('carta.config.' . $type)</a>
			@endswitch
		@endforeach
	</div>
</div>