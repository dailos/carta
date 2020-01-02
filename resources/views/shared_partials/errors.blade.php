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

@if(Session::has('alert'))
    <div class="alert alert-danger">
        {{ Session::get('alert') }}
    </div>
@endif
