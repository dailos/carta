<div v-show="error_items.length > 0" class="container">
	<div class="alert alert-danger" role="alert">
	 	Hay <a tabindex="0" data-popover-content="#a1" data-toggle="popover" title="Errores en el formulario" data-trigger="focus" role="button">errores</a> en el formulario.
	</div>

	<div v-show="false" id="a1">
		<ul>
			<li v-for="item in error_items">
				- @{{ item }}
			</li>
		</ul>
	</div>
</div>

@if($errors->any())
<div v-show="error_items.length == 0" class="container">
	<div class="alert alert-danger" role="alert">
	 	Hay <a tabindex="0" href="#" data-popover-content="#a2" data-toggle="popover" title="Errores en el formulario" data-trigger="focus" role="button">errores</a> en el formulario.
	</div>

	<div v-show="false" id="a2">
		<ul>
			@foreach(array_unique ($errors->all()) as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
</div>
@endif