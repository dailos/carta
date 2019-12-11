<!-- Campos búsqueda simplea -->
<div v-show="busqueda_select == 'simple'">
	<form action="{{ route('fichas.search') }}">
		<div class="form-row">
			<div class="form-group col-lg-4">
				<label for="query">Palabras clave</label>
				<input class="form-control" id="query" name="query" type="text">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-lg-4">
				<label>Buscar</label>
				<select class="custom-select cajadelbuscar" id="inputGroupSelect01" name="search_key">
				<option value="todas" selected>Todas</option>
				<option value="cualquiera">Cualquiera de</option>
				</select> las palabras clave
			</div>
			<div class="form-group col-lg-4 left">
				<button :disabled="errors.has('query')" type="submit" class="btn">Buscar</button>
			</div>
		</div>
	</form>
</div>

<!-- Campos búsqueda avanzada -->
<div v-show="busqueda_select == 'avanzada'">
	<form action="{{ route('fichas.search') }}">
		<div class="form-row">
			<div class="form-group col-lg-4">
				<label>Municipio</label>
				<select2 :options="municipios" :placeholder="placeholder_municipio" :allowclear="allow" name="municipio"></select2>
			</div>

			<div class="form-group col-lg-4">
				<label>Actividad</label>
				<select2 :options="actividades" :placeholder="placeholder_actividad" :allowclear="allow" class="form-control" name="actividad"></select2>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-lg-4">
				<label>Grupo</label>
				<select2 :options="grupos" :placeholder="placeholder_grupo" :allowclear="allow" class="form-control" name="grupo"></select2>
			</div>

			<div class="form-group col-lg-4">
				<label>Tipo</label>
				<select2 :options="tipos" :placeholder="placeholder_tipo" :allowclear="allow" class="form-control" name="tipo"></select2>
			</div>		
		</div>	

		<div class="form-row">
				<label for="query">Palabra(s) clave(s)</label>
			<div class="input-group input-group-sm col-lg-4 mb-3">
				<input id="query" class="form-control" name="query" type="text">
			</div>
		</div>	

		<div class="form-row">
			<div class="form-group col-lg-4">
				<label>Buscar</label>
				<select class="custom-select cajadelbuscar" id="inputGroupSelect01" name="search_key">
				<option value="todas" selected>Todas</option>
				<option value="cualquiera">Cualquiera de</option>
				</select> las palabras clave					
			</div>
			<div class="form-group col-lg-4 left">
				<button type="submit" class="btn">Buscar</button>
			</div>
		</div>
	</form>
</div>

<!-- Acceso directo a la ficha -->
<div v-show="busqueda_select == 'acceso_directo'">
	<form action="{{ route('fichas.search.code') }}" method="post">
		@csrf
		<div class="form-row align-items-start">
			<div class="form-group col-lg-4">
				<input v-validate="'required|numeric|max:10'" data-vv-as="@lang('validation.attributes.cod_ficha')" id="cod_ficha" type="text" name="cod_ficha" placeholder="Número de ficha" class="form-control{{ $errors->has('cod_ficha') ? ' is-invalid' : '' }}" value="{{ old('cod_ficha') }}" autofocus>

				@errorvee(['field' => 'cod_ficha'])@enderrorvee
				@errorlaravel(['field' => 'cod_ficha'])@enderrorlaravel
			</div>

			<div class="form-group col-lg-4 left">
				<button :disabled="errors.has('cod_ficha')" type="submit" class="btn">Abrir ficha</button>
			</div>
		</div>
		
		<input v-model="busqueda_select" type="hidden" name="busqueda_select">
		
	</form>
</div>

<!-- Campos búsqueda geográfica -->
<div v-show="busqueda_select == 'geo'">
	<form action="{{ route('fichas.search.geo.file') }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="form-row">
			<div class="form-group col-lg-4">
				<label>Fichero ".KML" o ".KMZ &nbsp;</label>
				<input type="file" name="kml" class="file-control" required>
			</div>
			<div class="form-group">
				<button type="submit" class="btn">Enviar</button>
			</div>
		</div>
	</form>
</div>

<!-- Campos búsqueda por proximidad geográfica -->
<div v-show="busqueda_select == 'geoprox'">
	<div class="form-row">
		<div id="map" class="form-group col map-show"></div>
	</div>
	<form action="{{ route('fichas.search.geoprox') }}">
	<div class="form-row">		
		<div class="form-group col-lg-4">
			<label>Latitud</label>
			<input id="latitud" type="text" name="latitud" class="form-control" required>
		</div>		
	</div>
	<div class="form-row">
		<div class="form-group col-lg-4">
			<label>Longitud</label>
			<input id="longitud" type="text" name="longitud" class="form-control" required>
		</div>		
	</div>
	<div class="form-row">
		<div class="form-group col-lg-4">
			<label>Tamaño del área (metros)</label>
			<input id="radio" v-model="radio" type="text" name="radio" class="form-control" required>
		</div>		
	</div>
	<div class="form-row">
		<div class="form-group">
			<button type="submit" class="btn">Buscar</button>
		</div>
	</div>
	</form>
</div>