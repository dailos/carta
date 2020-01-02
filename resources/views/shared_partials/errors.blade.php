@if($errors->any())
<div class="alert alert-danger">
	<div class="form-group">
		<ul class="errors">
			@foreach(array_unique ($errors->all()) as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
</div>
@endif
