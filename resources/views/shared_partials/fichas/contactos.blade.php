<p><h3>Información de contacto</h3></p>
<div class="row">
	<div class="col-lg-6">
		<label>Tipo de usuario</label>
		<select v-model="selected" class="custom-select" v-on:change="option = selected">
			@foreach ($tipos_contacto as $tipo)
				<option value="{{ $tipo->id }}"> {{ $tipo->nombre }} </option>
			@endforeach
		</select>
	</div>
</div>

<br>

@foreach ($tipos_contacto as $tipo)

	<div v-show="option == {{ $tipo->id }}">
		<div class="form-row">
			<div class="form-group col-lg-6">
				<label>Nombre</label>
				<input v-validate="'max:255'" data-vv-as="Nombre del {{ $tipo->nombre }}" type="text" class="form-control" name="contactos[{{ $tipo->id }}][nombre]" placeholder="Nombre de {{ $tipo->nombre }}" value="{{ form_value((isset($ficha->contactos[$tipo->id])) ? (isset($ficha->contactos[$tipo->id]['nombre']) ? $ficha->contactos[$tipo->id]['nombre'] : null) : null, 'contactos.' . $tipo->id . '.nombre', $errors) }}">
			</div>

			@errorvee(['field' => 'contactos[' . $tipo->id . '][nombre]'])@enderrorvee
			@errorlaravel(['field' => 'contactos[' . $tipo->id . '][nombre]'])@enderrorlaravel
			
			<div class="form-group col-lg-6">
				<label>Nº documento (DNI/NIE/CIF)</label>
				<input v-validate="'max:255'" data-vv-as="Nº documento del {{ $tipo->nombre }}" type="text" class="form-control" name="contactos[{{ $tipo->id }}][id_documento]"  placeholder="Nº de documento" value="{{ form_value((isset($ficha->contactos[$tipo->id])) ? (isset($ficha->contactos[$tipo->id]['id_documento']) ? $ficha->contactos[$tipo->id]['id_documento'] : null) : null, 'contactos.' . $tipo->id . '.id_documento', $errors) }}">
			</div>

			@errorvee(['field' => 'contactos[' . $tipo->id . '][id_documento]'])@enderrorvee
			@errorlaravel(['field' => 'contactos[' . $tipo->id . '][id_documento]'])@enderrorlaravel
		</div>

		<br>

		<div class="form-row">
			<div class="form-group col-lg-6">
				<label>Teléfono</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">
							<i class="fas fa-phone" aria-hidden="true"></i>
						</span>
					</div>
					<input v-validate="'max:255'" data-vv-as="Teléfono del {{ $tipo->nombre }}" type="text" class="form-control" name="contactos[{{ $tipo->id }}][telefono]"  placeholder="Teléfono" value="{{ form_value((isset($ficha->contactos[$tipo->id])) ? (isset($ficha->contactos[$tipo->id]['telefono']) ? $ficha->contactos[$tipo->id]['telefono'] : null) : null, 'contactos.' . $tipo->id . '.telefono', $errors) }}" aria-label="Teléfono" aria-describedby="basic-addon1" autofocus>
				</div>

			@errorvee(['field' => 'contactos[' . $tipo->id . '][telefono]'])@enderrorvee
			@errorlaravel(['field' => 'contactos[' . $tipo->id . '][telefono]'])@enderrorlaravel
			</div>

			<div class="form-group col-lg-6">
				<label>Dirección de correo electrónico</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon2">
							<i class="fa fa-at" aria-hidden="true"></i>
						</span>
					</div>
					<input v-validate="'max:255'" data-vv-as="Dirección email del {{ $tipo->nombre }}" type="text" class="form-control" name="contactos[{{ $tipo->id }}][email]"  placeholder="Dirección email" value="{{ form_value((isset($ficha->contactos[$tipo->id])) ? (isset($ficha->contactos[$tipo->id]['email']) ? $ficha->contactos[$tipo->id]['email'] : null) : null, 'contactos.' . $tipo->id . '.email', $errors) }}" aria-label="Email" aria-describedby="basic-addon2" autofocus>
				</div>

			@errorvee(['field' => 'contactos[' . $tipo->id . '][email]'])@enderrorvee
			@errorlaravel(['field' => 'contactos[' . $tipo->id . '][email]'])@enderrorlaravel
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-lg-6">
				<label>Dirección</label>
				<input v-validate="'max:255'" data-vv-as="Dirección del {{ $tipo->nombre }}" type="text" class="form-control" name="contactos[{{ $tipo->id }}][direccion]"  placeholder="Dirección" value="{{ form_value((isset($ficha->contactos[$tipo->id])) ? (isset($ficha->contactos[$tipo->id]['direccion']) ? $ficha->contactos[$tipo->id]['direccion'] : null) : null, 'contactos.' . $tipo->id . '.direccion', $errors) }}">
			</div>

			@errorvee(['field' => 'contactos[' . $tipo->id . '][direccion]'])@enderrorvee
			@errorlaravel(['field' => 'contactos[' . $tipo->id . '][direccion]'])@enderrorlaravel
		</div>
	</div>

@endforeach
