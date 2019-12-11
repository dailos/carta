
<div class="container filters" v-show="filter == 'localizacion'">
	<p><h3>Localización</h3></p>

	<div class="form-row">
		<div class="form-group col-lg-6">
			<label class="col-form-label col-form-label-sm">Cod.Ficha</label>
			<input v-validate="'numeric|max:255'" data-vv-as="@lang('validation.attributes.cod_ficha')"
			 id="cod_ficha" type="text" class="form-control form-control-sm" name="cod_ficha" value="">
			 @errorvee(['field' => 'cod_ficha'])@enderrorvee
		</div>

		<div class="form-group col-lg-6">
			<label class="col-form-label col-form-label-sm">Denominación</label>
			<input v-validate="'max:255'" data-vv-as="@lang('validation.attributes.denominacion')" id="denominacion" type="text" class="form-control form-control-sm" name="denominacion">

			@errorvee(['field' => 'denominacion'])@enderrorvee
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-lg-4">
		@role('admin')
			<label class="col-form-label col-form-label-sm">Isla</label>
			<select2 id="isla_id" :options="islas" :allowclear="allow" :placeholder="placeholder_isla" name="isla_id" v-model="isla" @input="getMunicipios"></select2>
		@endrole
			
		@role('collaborator')
			<label class="col-form-label col-form-label-sm">Isla</label>
			<select2 id="isla_id" :options="islas" :allowclear="allow" :placeholder="placeholder_isla" v-model="isla" disabled></select2>

			<input type="hidden" name="isla_id" value="{{ config('carta.isla') }}">
		@endrole
		</div>

		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm">Municipio</label>
			<select2 id="municipio_id" :options="municipios" :allowclear="allow" :placeholder="placeholder_municipio" name="municipio_id" v-model="municipio" @input="getLocalidades"></select2>
		</div>

		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm">Localidad</label>
			<select2 id="localidad_id" :options="localidades" :allowclear="allow" :placeholder="placeholder_localidad" name="localidad_id" v-model="localidad"></select2>
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-lg-10">
			<label class="col-form-label col-form-label-sm">Dirección</label>
			<input v-validate="'max:100'" data-vv-as="@lang('validation.attributes.direccion')" id="direccion" type="text" class="form-control form-control-sm" name="direccion" autofocus>

			@errorvee(['field' => 'direccion'])@enderrorvee
		</div>

		<div class="form-group col-lg-2">
			<label class="col-form-label col-form-label-sm">Cod. Postal</label>
			<input v-validate="'max:20'" data-vv-as="@lang('validation.attributes.cod_postal')" id="cod_postal" type="text" class="form-control form-control-sm" name="cod_postal" autofocus>

			@errorvee(['field' => 'cod_postal'])@enderrorvee
		</div>
	</div>


	<div class="form-row">
		<div class="form-group col-lg-6">
			<label class="col-form-label col-form-label-sm">Toponimias</label>
			<input v-validate="'max:100'" data-vv-as="@lang('validation.attributes.toponimias')" id="toponimias" type="text" class="form-control form-control-sm" name="toponimias" autofocus>

			@errorvee(['field' => 'toponimias'])@enderrorvee
		</div>
	</div>
</div>

<div class="container filters" v-show="filter == 'clasificacion'">
	<p><h3>Clasificación</h3></p>
	<div class="form-row">
		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm">Actividad</label>
			<select2 :options="actividades" :placeholder="placeholder_actividad" :allowclear="allow" class="form-control form-control-sm" id="actividad_id" v-model="actividad"></select2>
		</div>
		
		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm">Grupo</label>
			<select2 :options="grupos" :placeholder="placeholder_grupo" :allowclear="allow" class="form-control form-control-sm" id="grupo_id" v-model="grupo"></select2>
		</div>

		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm">Tipo</label>
			<select2 :options="tipos" :placeholder="placeholder_tipo" :allowclear="allow" class="form-control form-control-sm" id="tipo_id" v-model="tipo"></select2>
		</div>
	</div>
</div>

<div class="container filters" v-show="filter == 'estado'">

	<p><h3>Clasificación</h3></p>

	<div class="form-row">
		<div class="form-group col-lg-6">
			<label class="col-form-label col-form-label-sm">Descripción</label>
			<input type="text" name="descripcion" class="form-control form-control-sm" id="descripcion">
		</div>

		<div class="form-group col-lg-6">
			<label class="col-form-label col-form-label-sm">Historia</label>
			<input type="text" name="historia" class="form-control form-control-sm" id="historia">
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-lg-4">
			<label for="propiedad_id" class="col-form-label col-form-label-sm">Propiedad</label>
			<select2 :options="propiedades" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" id="propiedad_id" v-model="propiedad"></select2>
		</div>

		<div class="form-group col-lg-4">
			<label for="grado_proteccion_id" class="col-form-label col-form-label-sm">Grado Protección</label>
			<select2 :options="grados_proteccion" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" id="grado_proteccion_id" v-model="grado_proteccion"></select2>
		</div>

		<div class="form-group col-lg-4">
			<label for="nivel_proteccion" class="col-form-label col-form-label-sm">Nivel protección</label>
			<input v-validate="'between:0,9'" data-vv-as="@lang('validation.attributes.nivel_proteccion')" id="nivel_proteccion" type="text" class="form-control  form-control-sm{{ $errors->has('nivel_proteccion') ? ' is-invalid' : '' }}" name="nivel_proteccion" value="{{ form_value(isset($ficha) ? $ficha->nivel_proteccion : null, 'nivel_proteccion', $errors) }}" autofocus>

			@errorvee(['field' => 'nivel_proteccion'])@enderrorvee
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm" for="estado_id">Estado de Conservación</label>
			<select2 :options="estados" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" id="estado_id" v-model="estado"></select2>
		</div>

		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm" for="fragilidad_id">Fragilidad</label>
			<select2 :options="fragilidades" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" id="fragilidad_id" v-model="fragilidad"></select2>
		</div>

		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm" for="valor_cientifico_id">Valor Científico</label>
			<select2 :options="valores_cientificos" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" id="valor_cientifico_id" v-model="valor_cientifico"></select2>
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-lg-4">
			<label for="uso_actual_id" class="col-form-label col-form-label-sm">Uso Actual</label>
			<select2 :options="usos_actuales" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" id="uso_actual_id" v-model="uso_actual"></select2>
		</div>

		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm" for="clasificacion_suelo_id">Clasificación Suelo</label>
			<select2 :options="calificaciones_suelo" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" id="clasificacion_suelo_id" v-model="clasificacion_suelo"></select2>
		</div>

		<div class="form-group col-lg-4">
			<label class="col-form-label col-form-label-sm" for="calificacion_suelo_id">Calificación Suelo</label>
			<select2 :options="calificaciones_suelo" :placeholder="placeholder_generico" :allowclear="allow" class="form-control" id="calificacion_suelo_id" v-model="calificacion_suelo"></select2>
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-lg-6">
			<label class="col-form-label col-form-label-sm">Sugerencias</label>
			<input type="text" name="sugerencias" class="form-control form-control-sm" id="sugerencias">
		</div>

		<div class="form-group col-lg-6">
			<label class="col-form-label col-form-label-sm">Obs Generales</label>
			<input type="text" name="obs_generales" class="form-control form-control-sm" id="obs_generales">
		</div>
	</div>
</div>

<div class="container filters" v-show="filter == 'contactos'">

	<p><h3>Contactos</h3></p>
	<div class="form-row">
		<div class="form-group col-lg-6">
			<label class="col-form-label col-form-label-sm">Dato del contacto</label>
			<input type="text" name="contactos" class="form-control form-control-sm" id="contactos">
		</div>
	</div>
</div>