<div class="row">
	<div class="col-lg-12 table-responsive">
		<table class="table table-striped">
		  <tbody>
		    <tr>
		      <th scope="row">Cod_ficha</th>
		      <td>{{ $ficha->cod_ficha }}</td>
		    </tr>

		    <tr>
		      <th scope="row">UTM Cuadrante</th>
		      <td>{{ $ficha->zona_UTM }}</td>
		    </tr>

		    <tr>
		      <th scope="row">X</th>
		      <td>{{ $ficha->X }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Y</th>
		      <td>{{ $ficha->Y }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Latitud</th>
		      <td>{{ $ficha->latitud }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Longitud</th>
		      <td>{{ $ficha->longitud }}</td>
		    </tr>
		    
		    <tr>
		      <th scope="row">Denominación</th>
		      <td>{{ $ficha->denominacion }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Isla</th>
		      <td>@isset($ficha->isla){{ $ficha->isla->nombre }}@endisset</td>
		    </tr>

		    <tr>
		      <th scope="row">Municipio</th>
		      <td>@isset($ficha->municipio){{ $ficha->municipio->nombre }}@endisset</td>
		    </tr>

		    <tr>
		      <th scope="row">Localidad</th>
		      <td>@isset($ficha->localidad){{ $ficha->localidad->nombre }}@endisset</td>
		    </tr>

		    <tr>
		    	<th scope="row">Lugar</th>
		    	<td>{{ $ficha->lugar }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Código de Patrimonio Histórico</th>
		      <td>{{ $ficha->numero_dgph }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Actividad</th>
		      <td>@isset($ficha->actividad){{ $ficha->actividad->nombre }}@endisset</td>
		    </tr>

		    <tr>
		      <th scope="row">Grupo</th>
		      <td>@isset($ficha->grupo){{ $ficha->grupo->nombre }}@endisset</td>
		    </tr>

		    <tr>
		      <th scope="row">Tipo</th>
		      <td>@isset($ficha->tipo){{ $ficha->tipo->nombre }}@endisset</td>
		    </tr>

		    <tr>
		      <th scope="row">Dirección</th>
		      <td>{{ $ficha->direccion }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Código postal</th>
		      <td>{{ $ficha->cod_postal }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Teléfono</th>
		      <td>{{ $ficha->telefono }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Altitud</th>
		      <td>{{ $ficha->altitud }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Toponimias</th>
		      <td>{{ $ficha->toponimias }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Cartografía</th>
		      <td>{{ $ficha->cartografia }}</td>
		    </tr>

		    <tr>
		      <th scope="row">Obs. Localización</th>
		      <td>{{ $ficha->obs_localizacion }}</td>
		    </tr>

			<tr>
				<th scope="row">Descripción</th>
				<td>{{ $ficha->descripcion }}</td>
			</tr>

			<tr>
				<th scope="row">Historia</th>
				<td>{{ $ficha->historia }}</td>
			</tr>

			<tr>
				<th scope="row">Fecha Construcción</th>
				<td>{{ $ficha->fecha_construccion }}</td>
			</tr>

			<tr>
				<th scope="row">Antigüedad</th>
				<td>@isset($ficha->antiguedad){{ $ficha->antiguedad->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Superficie</th>
				<td>{{ $ficha->superficie }}</td>
			</tr>

			<tr>
				<th scope="row">Uso Actual</th>
				<td>@isset($ficha->uso_actual){{ $ficha->uso_actual->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Destrucción Obras</th>
				<td>{{ $ficha->dest_obras_text }}</td>
			</tr>

			<tr>
				<th scope="row">Saqueos</th>
				<td>{{ $ficha->saqueos_text }}</td>
			</tr>

			<tr>
				<th scope="row">Alteraciones naturales</th>
				<td>{{ $ficha->alte_naturales_text }}</td>
			</tr>

			<tr>
				<th scope="row">Otras</th>
				<td>{{ $ficha->otras_text }}</td>
			</tr>

			<tr>
				<th scope="row">Estado de Conservación</th>
				<td>@isset($ficha->estado){{ $ficha->estado->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Fragilidad</th>
				<td>@isset($ficha->fragilidad){{ $ficha->fragilidad->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Valor Científico</th>
				<td>@isset($ficha->valor_cientifico){{ $ficha->valor_cientifico->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Obs Estado</th>
				<td>{{ $ficha->obs_estado }}</td>
			</tr>

			<tr>
				<th scope="row">Documentación</th>
				<td>{{ $ficha->documentacion }}</td>
			</tr>

			<tr>
				<th scope="row">Propiedad</th>
				<td>@isset($ficha->propiedad){{ $ficha->propiedad->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Declaración B.I.C.</th>
				<td>{{ $ficha->declaracion_BIC_text }}</td>
			</tr>

			<tr>
				<th scope="row">Fecha incoación</th>
				<td>@isset($ficha->fecha_incoacion){{ $ficha->fecha_incoacion_formated }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Fecha declaración</th>
				<td>@isset($ficha->fecha_declaracion){{ $ficha->fecha_declaracion_formated }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Clasificación Suelo</th>
				<td>@isset($ficha->clasificacion_suelo){{ $ficha->clasificacion_suelo->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Calificación Suelo</th>
				<td>@isset($ficha->calificacion_suelo){{ $ficha->calificacion_suelo->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Catalogo</th>
				<td>{{ $ficha->catalogo }}</td>
			</tr>

			<tr>
				<th scope="row">Nivel protección</th>
				<td>{{ $ficha->nivel_proteccion }}</td>
			</tr>

			<tr>
				<th scope="row">Grado Protección</th>
				<td>@isset($ficha->grado_proteccion){{ $ficha->grado_proteccion->nombre }}@endisset</td>
			</tr>

			<tr>
				<th scope="row">Intervenciones</th>
				<td>{{ $ficha->intervenciones }}</td>
			</div>

			<tr>
				<th scope="row">Sugerencias</th>
				<td>{{ $ficha->sugerencias }}</td>
			</tr>

			<tr>
				<th scope="row">Obs Generales</th>
				<td>{{ $ficha->obs_generales }}</td>
			</tr>

			@if($ficha->contactos)
				@foreach ($ficha->contactos as $key => $contacto)
				<tr>
					<th scope="row">{{ $tipos_contacto->firstWhere('id', $key)->nombre }}</th>
					<td>@foreach($contacto as $clave => $valor)
							<strong>{{ ucfirst($clave) }}:</strong> {{ $valor }}
							@if (!$loop->last)
								<br>
							@endif
						@endforeach
					</td>
				</tr>
				@endforeach
			@endif

			<tr>
				<th scope="row">Enlaces de interes</th>
				<td>@isset($ficha->enlaces)
					@foreach ($ficha->enlaces as $enlace)
						{{ $enlace['url'] }}
						@if (!$loop->last)
						<br>
						@endif
					@endforeach
					@endisset
				</td>
			</tr>

			<tr>
				<th scope="row">Multimedia</th>
				<td>@isset($ficha->multimedia)
					@foreach ($ficha->multimedia as $multimedia)
						{{ $multimedia['url'] }}
						@if (!$loop->last)
						<br>
						@endif
					@endforeach
					@endisset
				</td>
			</tr>

		  </tbody>
		</table>

	</div>
</div>