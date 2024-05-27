<div class="form-row">
	<div class="form-group col-lg-12">
		<label for="descripcion">Descripción</label>
		<textarea name="descripcion" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" id="descripcion" autofocuscols="30" rows="5">{{ form_value(isset($ficha) ? $ficha->descripcion : null, 'descripcion', $errors) }}</textarea>

		@errorvee(['field' => 'descripcion'])@enderrorvee
		@errorlaravel(['field' => 'descripcion'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label for="historia">Historia</label>
		<textarea name="historia" class="form-control{{ $errors->has('historia') ? ' is-invalid' : '' }}" id="historia" autofocuscols="30" rows="5">{{ form_value(isset($ficha) ? $ficha->historia : null, 'historia', $errors) }}</textarea>

		@errorvee(['field' => 'historia'])@enderrorvee
		@errorlaravel(['field' => 'historia'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="col-lg-4">
		<label for="fecha_construccion">Fecha Construcción</label>
		<input v-validate="'max:50'" data-vv-as="@lang('validation.attributes.fecha_construccion')" id="fecha_construccion" type="text" class="form-control{{ $errors->has('fecha_construccion') ? ' is-invalid' : '' }}" name="fecha_construccion" value="{{ form_value(isset($ficha) ? $ficha->fecha_construccion : null, 'fecha_construccion', $errors) }}" autofocus>

		@errorvee(['field' => 'fecha_construccion'])@enderrorvee
		@errorlaravel(['field' => 'fecha_construccion'])@enderrorlaravel
	</div>

	<div class="col-lg-4">
		<label for="antiguedad_id">Antigüedad</label>

		<select2 :options="antiguedades" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('antiguedad_id')) class=" is-invalid" @endif name="antiguedad_id" v-model="antiguedad"></select2>

		@errorvee(['field' => 'antiguedad_id'])@enderrorvee
		@errorlaravel(['field' => 'antiguedad_id'])@enderrorlaravel
	</div>

	<div class="col-lg-4">
		<label for="superficie">Superficie</label>
		<div class="input-group mb-3">
			<input v-validate="'numeric|max:10'" data-vv-as="@lang('validation.attributes.superficie')" id="superficie" type="text" class="form-control{{ $errors->has('superficie') ? ' is-invalid' : '' }}" name="superficie" value="{{ form_value(isset($ficha) ? $ficha->superficie : null, 'superficie', $errors) }}" placeholder="Superficie" aria-label="Superficie" aria-describedby="basic-addon2" autofocus>
			<div class="input-group-append">
			    <span class="input-group-text" id="basic-addon2">m2</span>
			</div>

			@errorvee(['field' => 'superficie'])@enderrorvee
			@errorlaravel(['field' => 'superficie'])@enderrorlaravel
		</div>
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-4">
		<label for="uso_actual_id">Uso Actual</label>
		<select2 :options="usos_actuales" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('uso_actual_id')) class=" is-invalid" @endif name="uso_actual_id" v-model="uso_actual"></select2>

		@errorvee(['field' => 'uso_actual_id'])@enderrorvee
		@errorlaravel(['field' => 'uso_actual_id'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-6">
		<label for="">Alteraciones</label>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="dest_obras" name="dest_obras" @if(form_value(isset($ficha) ? $ficha->dest_obras : null, 'dest_obras', $errors)) checked="checked" @endif>
			<label class="custom-control-label" for="dest_obras">Destrucción por Obras</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="saqueos" name="saqueos" @if(form_value(isset($ficha) ? $ficha->saqueos : null, 'saqueos', $errors)) checked="checked" @endif>
			<label class="custom-control-label" for="saqueos">Saqueos</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="otras" name="otras" @if(form_value(isset($ficha) ? $ficha->otras : null, 'otras', $errors)) checked="checked" @endif>
			<label class="custom-control-label" for="otras">Otras</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="alte_naturales" name="alte_naturales" @if(form_value(isset($ficha) ? $ficha->alte_naturales : null, 'alte_naturales', $errors)) checked="checked" @endif>
			<label class="custom-control-label" for="alte_naturales">Alteraciones Naturales</label>
		</div>
	</div>
</div>


<div class="form-row">
	<div class="form-group col-lg-4">
		<label for="estado_id">Estado de Conservación</label>
		<select2 :options="estados" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('estado_id')) class=" is-invalid" @endif name="estado_id" v-model="estado"></select2>

		@errorvee(['field' => 'estado_id'])@enderrorvee
		@errorlaravel(['field' => 'estado_id'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-4">
		<label for="fragilidad_id">Fragilidad</label>
		<select2 :options="fragilidades" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('fragilidad_id')) class=" is-invalid" @endif name="fragilidad_id" v-model="fragilidad"></select2>

		@errorvee(['field' => 'fragilidad_id'])@enderrorvee
		@errorlaravel(['field' => 'fragilidad_id'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-4">
		<label for="valor_cientifico_id">Valor Científico</label>
		<select2 :options="valores_cientificos" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('valor_cientifico_id')) class=" is-invalid" @endif name="valor_cientifico_id" v-model="valor_cientifico"></select2>

		@errorvee(['field' => 'valor_cientifico_id'])@enderrorvee
		@errorlaravel(['field' => 'valor_cientifico_id'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label for="obs_estado">Obs Estado</label>
		<textarea name="obs_estado" class="form-control{{ $errors->has('obs_estado') ? ' is-invalid' : '' }}" id="obs_estado"  autofocuscols="30" rows="5">{{ form_value(isset($ficha) ? $ficha->obs_estado : null, 'obs_estado', $errors) }}</textarea>

		@errorvee(['field' => 'obs_estado'])@enderrorvee
		@errorlaravel(['field' => 'obs_estado'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label for="documentacion">Documentación</label>
		<textarea name="documentacion" class="form-control{{ $errors->has('documentacion') ? ' is-invalid' : '' }}" id="documentacion"  autofocuscols="30" rows="5">{{ form_value(isset($ficha) ? $ficha->documentacion : null, 'documentacion', $errors) }}</textarea>

		@errorvee(['field' => 'documentacion'])@enderrorvee
		@errorlaravel(['field' => 'documentacion'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-4">
		<label for="propiedad_id">Propiedad</label>
		<select2 :options="propiedades" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('propiedad_id')) class=" is-invalid" @endif name="propiedad_id" v-model="propiedad"></select2>

		@errorvee(['field' => 'propiedad_id'])@enderrorvee
		@errorlaravel(['field' => 'propiedad_id'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-4">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="declaracion_BIC" name="declaracion_BIC" @if(form_value(isset($ficha) ? $ficha->declaracion_BIC : null, 'declaracion_BIC', $errors)) checked="checked" @endif><br>
			<label class="custom-control-label" for="declaracion_BIC">Declaración B I C</label>
		</div>
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-4">
		<label for="fecha_incoacion">Fecha incoación</label>
		<div class='input-group date datetimepicker'>
	        <input v-validate="'date_format:dd/MM/yyyy'" data-vv-as="@lang('validation.attributes.fecha_incoacion')" type='text' class="form-control{{ $errors->has('fecha_incoacion') ? ' is-invalid' : '' }}" name="fecha_incoacion" value="{{ form_value(isset($ficha) ? (isset($ficha->fecha_incoacion) ? $ficha->fecha_incoacion_formated : null) : null, 'fecha_incoacion', $errors) }}" autofocus/>
	        <div class="input-group-append input-group-addon">
	            <span class="input-group-text">
	            	<i class="fa fa-calendar fa-lg" aria-hidden="true"></i>
	            </span>
	        </div>
	    </div>

		@errorvee(['field' => 'fecha_incoacion'])@enderrorvee
		@errorlaravel(['field' => 'fecha_incoacion'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-4">
		<label for="fecha_declaracion">Fecha declaración</label>
		<div class='input-group date datetimepicker'>
	        <input v-validate="'date_format:dd/MM/yyyy'" data-vv-as="@lang('validation.attributes.fecha_declaracion')" type='text' class="form-control{{ $errors->has('fecha_declaracion') ? ' is-invalid' : '' }}" name="fecha_declaracion" value="{{ form_value(isset($ficha) ? (isset($ficha->fecha_declaracion) ? $ficha->fecha_declaracion_formated : null) : null, 'fecha_declaracion', $errors) }}" autofocus/>
	        <div class="input-group-append input-group-addon">
	            <span class="input-group-text">
	            	<i class="fa fa-calendar fa-lg" aria-hidden="true"></i>
	            </span>
	        </div>
	    </div>

		@errorvee(['field' => 'fecha_declaracion'])@enderrorvee
		@errorlaravel(['field' => 'fecha_declaracion'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-4">
		<label for="clasificacion_suelo_id">Clasificación Suelo</label>
		<select2 :options="clasificaciones_suelo" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('clasificacion_suelo_id')) class=" is-invalid" @endif name="clasificacion_suelo_id" v-model="clasificacion_suelo"></select2>

		@errorvee(['field' => 'clasificacion_suelo_id'])@enderrorvee
		@errorlaravel(['field' => 'clasificacion_suelo_id'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-4">
		<label for="calificacion_suelo_id">Calificación Suelo</label>
		<select2 :options="calificaciones_suelo" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('calificacion_suelo_id')) class=" is-invalid" @endif name="calificacion_suelo_id" v-model="calificacion_suelo"></select2>

		@errorvee(['field' => 'calificacion_suelo_id'])@enderrorvee
		@errorlaravel(['field' => 'calificacion_suelo_id'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label for="catalogo">Catálogo</label>
		<input v-validate="'max:50'" data-vv-as="@lang('validation.attributes.catalogo')" id="catalogo" type="text" class="form-control{{ $errors->has('catalogo') ? ' is-invalid' : '' }}" name="catalogo" value="{{ form_value(isset($ficha) ? $ficha->catalogo : null, 'catalogo', $errors) }}" autofocus>

		@errorvee(['field' => 'catalogo'])@enderrorvee
		@errorlaravel(['field' => 'catalogo'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-4">
		<label for="nivel_proteccion">Nivel protección (0-9)</label>

		<input v-validate="'between:0,9'" data-vv-as="@lang('validation.attributes.nivel_proteccion')" id="nivel_proteccion" type="text" class="form-control{{ $errors->has('nivel_proteccion') ? ' is-invalid' : '' }}" name="nivel_proteccion" value="{{ form_value(isset($ficha) ? $ficha->nivel_proteccion : null, 'nivel_proteccion', $errors) }}" placeholder="Introduzca un número del 0 al 9" autofocus>

		@errorvee(['field' => 'nivel_proteccion'])@enderrorvee
		@errorlaravel(['field' => 'nivel_proteccion'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-4">
		<label for="grado_proteccion_id">Grado Protección</label>
		<select2 :options="grados_proteccion" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" @if($errors->has('grado_proteccion_id')) class=" is-invalid" @endif name="grado_proteccion_id" v-model="grado_proteccion"></select2>

		@errorvee(['field' => 'grado_proteccion_id'])@enderrorvee
		@errorlaravel(['field' => 'grado_proteccion_id'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label>Intervenciones</label>
		<textarea name="intervenciones" class="form-control{{ $errors->has('intervenciones') ? ' is-invalid' : '' }}" id="intervenciones" autofocuscols="30" rows="5">{{ form_value(isset($ficha) ? $ficha->intervenciones : null, 'intervenciones', $errors) }}</textarea>

		@errorvee(['field' => 'intervenciones'])@enderrorvee
		@errorlaravel(['field' => 'intervenciones'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label>Sugerencias</label>
		<textarea name="sugerencias" class="form-control{{ $errors->has('sugerencias') ? ' is-invalid' : '' }}" id="sugerencias"  autofocuscols="30" rows="5">{{ form_value(isset($ficha) ? $ficha->sugerencias : null, 'sugerencias', $errors) }}</textarea>

		@errorvee(['field' => 'sugerencias'])@enderrorvee
		@errorlaravel(['field' => 'sugerencias'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label>Obs Generales</label>
		<textarea name="obs_generales" class="form-control{{ $errors->has('obs_generales') ? ' is-invalid' : '' }}" id="obs_generales"  autofocuscols="30" rows="5">{{ form_value(isset($ficha) ? $ficha->obs_generales : null, 'obs_generales', $errors) }}</textarea>

		@errorvee(['field' => 'obs_generales'])@enderrorvee
		@errorlaravel(['field' => 'obs_generales'])@enderrorlaravel
	</div>
</div>

