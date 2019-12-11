<p><h3>Coordenadas</h3></p>
<div class="row">
	<div class="col-lg-6">
		<div class="form-row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>U T M Cuadrante</label>
					<input v-validate="(x || y) ? 'required|numeric|between:1,60|' : 'numeric|between:1,60'" data-vv-as="@lang('validation.attributes.zona_UTM')" data-vv-scope="coords" id="zona_UTM" type="text" class="form-control{{ $errors->has('zona_UTM') ? ' is-invalid' : '' }}" name="zona_UTM" v-model="zona_utm" placeholder="Introduzca la zona sin la letra (R)" autofocus @input="latlon = ''">

					@errorvee(['field' => 'coords.zona_UTM'])@enderrorvee
					@errorlaravel(['field' => 'zona_UTM'])@enderrorlaravel
				</div>

				<div class="form-group">
					<label>X</label>
					<input v-validate="(zona_utm || y) ? 'required|numeric|between:100000,999999' : 'numeric|between:100000,999999'" data-vv-scope="coords" id="X" type="text" class="form-control{{ $errors->has('X') ? ' is-invalid' : '' }}" name="X" v-model="x" autofocus @input="latlon = ''">

					@errorvee(['field' => 'coords.X'])@enderrorvee
					@errorlaravel(['field' => 'X'])@enderrorlaravel
				</div>
				<div class="form-group">
					<label>Y</label>
					<input v-validate="(zona_utm || x) ? 'required|numeric|between:0,10000000' : 'numeric|between:0,10000000'" data-vv-scope="coords" id="Y" type="text" class="form-control{{ $errors->has('Y') ? ' is-invalid' : '' }}" name="Y" v-model="y" autofocus @input="latlon = ''">

					@errorvee(['field' => 'coords.Y'])@enderrorvee
					@errorlaravel(['field' => 'Y'])@enderrorlaravel
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Latitud</label>
					<input v-validate="(zona_utm && x && y) ? 'required|between:-90,90' : 'between:-90,90'" id="latitud" type="text" class="form-control{{ $errors->has('latitud') ? ' is-invalid' : '' }}" name="latitud" v-model="lat" readonly>

					@errorvee(['field' => 'latitud'])@enderrorvee
					@errorlaravel(['field' => 'latitud'])@enderrorlaravel
				</div>
				<div class="form-group">
					<label>Longitud</label>
					<input v-validate="(zona_utm && x && y) ? 'required|between:-180,180' : 'between:-180,180'" id="longitud" type="text" class="form-control{{ $errors->has('longitud') ? ' is-invalid' : '' }}" name="longitud" v-model="lon" readonly>

					@errorvee(['field' => 'longitud'])@enderrorvee
					@errorlaravel(['field' => 'longitud'])@enderrorlaravel
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
				<button 
					:disabled="x == '' || y == '' || zona_utm == '' || errors.has('zona_UTM') || errors.has('X') || errors.has('Y')" 
					v-on:click.prevent="localiza" 
					class="btn btn-outline-primary">Localiza</button>
			</div>
		</div>
	</div>
	<div id="map" class="col-lg-6 map-show"></div>
</div>
