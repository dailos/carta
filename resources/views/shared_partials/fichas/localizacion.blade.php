<p><h3>Localización</h3></p>

<div class="form-row">
	<div class="form-group col-lg-6">
		<label>Cod.Ficha</label>
		<input
		 id="cod_ficha" type="text" class="form-control" @isset($ficha) name="cod_ficha" value="{{ $ficha->cod_ficha }}" @endisset readonly>
	</div>

	<div class="form-group col-lg-6">
		<label>Cod. Pat. Histórico</label>
		<input v-validate="'max:255'" data-vv-as="@lang('validation.attributes.numero_dgph')" id="numero_dgph" type="text" class="form-control{{ $errors->has('numero_dgph') ? ' is-invalid' : '' }}" name="numero_dgph" value="{{ form_value(isset($ficha) ? $ficha->numero_dgph : null, 'numero_dgph', $errors) }}" autofocus>
		
		@errorvee(['field' => 'numero_dgph'])@enderrorvee
		@errorlaravel(['field' => 'numero_dgph'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label>Denominación</label>
		<input v-validate="'required|max:255'" data-vv-as="@lang('validation.attributes.denominacion')" id="denominacion" type="text" class="form-control{{ $errors->has('denominacion') ? ' is-invalid' : '' }}" name="denominacion" value="{{ form_value(isset($ficha) ? $ficha->denominacion : null, 'denominacion', $errors) }}" autofocus>

		@errorvee(['field' => 'denominacion'])@enderrorvee
		@errorlaravel(['field' => 'denominacion'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-6">
		<label>Cartografía</label>
		<input v-validate="'max:100'" data-vv-as="@lang('validation.attributes.cartografia')" id="cartografia" type="text" class="form-control{{ $errors->has('cartografia') ? ' is-invalid' : '' }}" name="cartografia" value="{{ form_value(isset($ficha) ? $ficha->cartografia : null, 'cartografia', $errors) }}" autofocus>

		@errorvee(['field' => 'cartografia'])@enderrorvee
		@errorlaravel(['field' => 'cartografia'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-6">
		<label>Altitud</label>
		<input v-validate="'numeric|max:10'" data-vv-as="@lang('validation.attributes.altitud')" id="altitud" type="text" class="form-control{{ $errors->has('altitud') ? ' is-invalid' : '' }}" name="altitud" value="{{ form_value(isset($ficha) ? $ficha->altitud : null, 'altitud', $errors) }}" autofocus>

		@errorvee(['field' => 'altitud'])@enderrorvee
		@errorlaravel(['field' => 'altitud'])@enderrorlaravel
	</div>
</div>


<div class="form-row">
	<div class="form-group col-lg-4">
	@role('admin')
		<label>Isla</label>
		<select2 v-validate="'required'" data-vv-as="@lang('validation.attributes.isla_id')" :options="islas" :placeholder="placeholder_isla" @if($errors->has('isla_id')) class=' is-invalid' @endif name="isla_id"  v-model="isla" @input="getMunicipios"></select2>

		@errorvee(['field' => 'isla_id'])@enderrorvee
		@errorlaravel(['field' => 'isla_id'])@enderrorlaravel
	@endrole
		
	@role('collaborator')
		<label>Isla</label>
		<select2 :options="islas" :placeholder="placeholder_isla" v-model="isla" disabled></select2>

		<input type="hidden" name="isla_id" value="{{ config('carta.isla') }}">
	@endrole
	</div>

	<div class="form-group col-lg-4">
		<label>Municipio</label>
		<select2 @role('collaborator')v-validate="'required'" data-vv-as="@lang('validation.attributes.municipio_id')"@endrole :options="municipios" :placeholder="placeholder_municipio" @if($errors->has('municipio_id')) class=" is-invalid" @endif name="municipio_id" v-model="municipio" @input="getLocalidades"></select2>

		@errorvee(['field' => 'municipio_id'])@enderrorvee
		@errorlaravel(['field' => 'municipio_id'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-4">
		<label>Localidad</label>
		<select2 :options="localidades" :allowclear="allow" :placeholder="placeholder_localidad" name="localidad_id" v-model="localidad"></select2>
	</div>
</div>

<div class="form-row">
	<div class="form-group col-12">
		<label>Lugar</label>
		<input v-validate="'max:255'" data-vv-as="@lang('validation.attributes.lugar')" id="lugar" type="text" class="form-control{{ $errors->has('lugar') ? ' is-invalid' : '' }}" name="lugar" value="{{ form_value(isset($ficha) ? $ficha->lugar : null, 'lugar', $errors) }}" placeholder="Nombre cómun del lugar" autofocus>

		@errorvee(['field' => 'lugar'])@enderrorvee
		@errorlaravel(['field' => 'lugar'])@enderrorlaravel
	</div>
</div>


<div class="form-row">
	<div class="form-group col-lg-10">
		<label>Dirección</label>
		<input v-validate="'max:100'" data-vv-as="@lang('validation.attributes.direccion')" id="direccion" type="text" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" value="{{ form_value(isset($ficha) ? $ficha->direccion : null, 'direccion', $errors) }}" autofocus>

		@errorvee(['field' => 'direccion'])@enderrorvee
		@errorlaravel(['field' => 'direccion'])@enderrorlaravel
	</div>

	<div class="form-group col-lg-2">
		<label>Cod. Postal</label>
		<input v-validate="'max:20'" data-vv-as="@lang('validation.attributes.cod_postal')" id="cod_postal" type="text" class="form-control{{ $errors->has('cod_postal') ? ' is-invalid' : '' }}" name="cod_postal" value="{{ form_value(isset($ficha) ? $ficha->cod_postal : null, 'cod_postal', $errors) }}" autofocus>

		@errorvee(['field' => 'cod_postal'])@enderrorvee
		@errorlaravel(['field' => 'cod_postal'])@enderrorlaravel
	</div>
</div>

<div class="form-row">
	<div class="form-group col-lg-12">
		<label>Obs. localización</label>
		<textarea name="obs_localizacion" class="form-control{{ $errors->has('obs_localizacion') ? ' is-invalid' : '' }}" id="obs_localizacion"  autofocuscols="30" rows="5">{{ form_value(isset($ficha) ? $ficha->obs_localizacion : null, 'obs_localizacion', $errors) }}</textarea>

		@errorvee(['field' => 'obs_localizacion'])@enderrorvee
		@errorlaravel(['field' => 'obs_localizacion'])@enderrorlaravel
	</div>				
</div>

<div class="form-row">
	<div class="form-group col-lg-6">
		<label>Toponimias</label>
		<input v-validate="'max:100'" data-vv-as="@lang('validation.attributes.toponimias')" id="toponimias" type="text" class="form-control{{ $errors->has('toponimias') ? ' is-invalid' : '' }}" name="toponimias" value="{{ form_value(isset($ficha) ? $ficha->toponimias : null, 'toponimias', $errors) }}" autofocus>

		@errorvee(['field' => 'toponimias'])@enderrorvee
		@errorlaravel(['field' => 'toponimias'])@enderrorlaravel
	</div>
	
	<div class="form-group col-lg-6">
		<label>Teléfono</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text"
				 id="basic-addon1">
					<i class="fas fa-phone" aria-hidden="true"></i>
				</span>
			</div>
			<input v-validate="'max:50'" data-vv-as="@lang('validation.attributes.telefono')" id="telefono"
			type="text" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{ form_value(isset($ficha) ? $ficha->telefono : null, 'telefono', $errors) }}" placeholder="Teléfono" aria-label="Teléfono" aria-describedby="basic-addon1" autofocus>
		</div>

		@errorvee(['field' => 'telefono'])@enderrorvee
		@errorlaravel(['field' => 'telefono'])@enderrorlaravel
	</div>
</div>
