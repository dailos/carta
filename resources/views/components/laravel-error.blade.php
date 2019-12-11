@if ($errors->has($field))
<span v-show="!errors.has('{{ $field }}')" class="invalid-feedback" role="alert">
	<strong>{{ $errors->first($field) }}</strong>
</span>
@endif