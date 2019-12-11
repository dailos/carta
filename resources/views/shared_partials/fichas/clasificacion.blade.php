<p><h3>Clasificación</h3></p>
<div class="row">
	<div class="col-lg-4">
		<label>Actividad</label>
		<select2 :options="actividades" :placeholder="placeholder_actividad" :allowclear="allow" class="form-control" @if($errors->has('actividad_id')) class=" is-invalid" @endif name="actividad_id" v-model="actividad"></select2>

		@errorlaravel(['field' => 'actividad_id'])@enderrorlaravel
	</div>
	<div class="col-lg-4">
		<label>Grupo</label>
		<select2 :options="grupos" :placeholder="placeholder_grupo" :allowclear="allow" class="form-control" @if($errors->has('grupo_id')) class=" is-invalid" @endif name="grupo_id" v-model="grupo"></select2>

		@errorlaravel(['field' => 'grupo_id'])@enderrorlaravel
	</div>
	<div class="col-lg-4">
		<label>Tipo</label>
		<select2 :options="tipos" :placeholder="placeholder_tipo" :allowclear="allow" class="form-control" @if($errors->has('tipo_id')) class=" is-invalid" @endif name="tipo_id" v-model="tipo"></select2>

		@errorlaravel(['field' => 'tipo_id'])@enderrorlaravel
	</div>
</div>
