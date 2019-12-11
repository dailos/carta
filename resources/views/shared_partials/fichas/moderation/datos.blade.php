<div class="row">
	<div class="col-lg-12 table-responsive">
		<table class="table table-striped">
		  <tbody>
		    <tr>
		      <td><strong>@lang('carta.cod_ficha')</strong></td>
		      @if(isset($nuevo_cod_ficha))
		      	<td>{{ $nuevo_cod_ficha }} (provisional)</td>
		      @elseif ($moderableRecord->model)
			  	<td>{{ $moderableRecord->model->cod_ficha }}</td>
			  @else
			  	<td></td>
		      @endif
		    </tr>

			@foreach ($ficha->getAttributes() as $key => $field)
				@if ($key == 'fotos' || $key == 'cod_ficha')
					@continue
				@elseif ($key == 'contactos')
					@if ($ficha->contactos)
						@foreach ($ficha->contactos as $key => $contacto)
						<tr>
							<td><strong>{{ $tipos_contacto->firstWhere('id', $key)->nombre }}</strong></td>
							<td>@foreach($contacto as $clave => $valor)
									<strong>{{ ucfirst($clave) }}:</strong> {{ $valor }}
									@if (!$loop->last)
										<br>
									@endif
								@endforeach
							</td>
						</tr>
						@endforeach
					@else {{-- Contactos borrados --}}
						<tr>
							<td><strong>Contactos</strong></td>
							<td></td>
						</tr>
					@endif
				@else
					<tr>
					  <td><strong>@lang('validation.attributes.' . $key)</strong></td>
					@switch($key)
					    @case('isla_id')
					    	<td>@if($ficha->isla){{ $ficha->isla->nombre }}@endif</td>
					        @break
					    @case('municipio_id')
					    	<td>@if($ficha->municipio){{ $ficha->municipio->nombre }}@endif</td>
					        @break
					    @case('localidad_id')
					    	<td>@if($ficha->localidad){{ $ficha->localidad->nombre }}@endif</td>
					        @break
					    @case('actividad_id')
					    	<td>@if($ficha->actividad){{ $ficha->actividad->nombre }}@endif</td>
					        @break
					    @case('grupo_id')
					    	<td>@if($ficha->grupo){{ $ficha->grupo->nombre }}@endif</td>
					        @break
					    @case('tipo_id')
					    	<td>@if($ficha->tipo){{ $ficha->tipo->nombre }}@endif</td>
					        @break
					    @case('antiguedad_id')
					    	<td>@if($ficha->antiguedad){{ $ficha->antiguedad->nombre }}@endif</td>
					        @break
					    @case('uso_actual_id')
					    	<td>@if($ficha->uso_actual){{ $ficha->uso_actual->nombre }}@endif</td>
					        @break
					    @case('dest_obras')
					    	<td>{{ $ficha->dest_obras_text }}</td>
					        @break
					    @case('saqueos')
					    	<td>{{ $ficha->saqueos_text }}</td>
					        @break
					    @case('alte_naturales')
					    	<td>{{ $ficha->alte_naturales_text }}</td>
					        @break
					    @case('otras')
					    	<td>{{ $ficha->otras_text }}</td>
					        @break
					    @case('estado_id')
					    	<td>@if($ficha->estado){{ $ficha->estado->nombre }}@endif</td>
					        @break
					    @case('fragilidad_id')
					    	<td>@if($ficha->fragilidad){{ $ficha->fragilidad->nombre }}@endif</td>
					        @break
					    @case('valor_cientifico_id')
					    	<td>@if($ficha->valor_cientifico){{ $ficha->valor_cientifico->nombre }}@endif</td>
					        @break
					    @case('propiedad_id')
					    	<td>@if($ficha->propiedad){{ $ficha->propiedad->nombre }}@endif</td>
					        @break
					    @case('declaracion_BIC')
					    	<td>{{ $ficha->declaracion_BIC_text }}</td>
					        @break
					    @case('fecha_incoacion')
					    	<td>@if($ficha->fecha_incoacion){{ $ficha->fecha_incoacion_formated }}@endif</td>
					        @break
					    @case('fecha_declaracion')
					    	<td>@if($ficha->fecha_declaracion){{ $ficha->fecha_declaracion_formated }}@endif</td>
					        @break
					    @case('clasificacion_suelo_id')
					    	<td>@if($ficha->clasificacion_suelo){{ $ficha->clasificacion_suelo->nombre }}@endif</td>
					        @break
					    @case('calificacion_suelo_id')
					    	<td>@if ($ficha->calificacion_suelo){{ $ficha->calificacion_suelo->nombre }}@endif</td>
					        @break
					    @case('grado_proteccion_id')
					    	<td>@if ($ficha->grado_proteccion){{ $ficha->grado_proteccion->nombre }}@endif</td>
					        @break
					    @case('enlaces')
					    	<td>@isset($ficha->enlaces)
					    		@foreach ($ficha->enlaces as $enlace)
					    			{{ $enlace['url'] }}
					    			@if (!$loop->last)
					    			<br>
					    			@endif
					    		@endforeach
					    		@endisset
					    	</td>
					        @break
					    @case('multimedia')
					    	<td>@isset($ficha->multimedia)
					    		@foreach ($ficha->multimedia as $multimedia)
					    			{{ $multimedia['url'] }}
					    			@if (!$loop->last)
					    			<br>
					    			@endif
					    		@endforeach
					    		@endisset
					    	</td>
					        @break
					    @default
							<td>{{ $field }}</td>
					@endswitch
					</tr>
				@endif
			@endforeach

		  </tbody>
		</table>

	</div>
</div>