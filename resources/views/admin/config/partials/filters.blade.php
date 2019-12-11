<form action="{{ route('admin.configuracion.index') }}" >
	<input type="hidden" name="type" value="{{ $type }}">

	<div class="form-group row mb-3">
		@if($type == 'municipio')
		<div class="col-lg-3">
			<select2 id="isla_id" :options="islas" :allowclear="allow" :placeholder="placeholder_isla" name="isla_id" v-model="isla"></select2>
		</div>
		@endif

		@if($type == 'localidad')
		<div class="col-lg-3">
			<select2 id="isla_id" :options="islas" :allowclear="allow" :placeholder="placeholder_isla" name="isla_id" v-model="isla" @input="getMunicipios"></select2>
		</div>
		<div class="col-lg-3">
			<select2 id="municipio_id" :options="municipios" :allowclear="allow" :placeholder="placeholder_municipio" name="municipio_id" v-model="municipio"></select2>
		</div>
		@endif

		<div class="col-lg-3 mb-3">
			<input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar" aria-label="Buscar" value="{{ $search }}">
		</div>

		<div class="col-lg-2">
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
		</div>
	</div>
</form>
