@if ($flash = session('status'))
    <div class="alert alert-success" role="alert">
        {{ $flash }}
    </div>
@endif

@if ($flash = session('message'))
	<div class="alert alert-success" role="alert">
	    {{ $flash }}
	</div>
@endif

@if ($flash = session('alert'))
	<div class="alert alert-danger" role="alert">
	    {{ $flash }}
	</div>
@endif