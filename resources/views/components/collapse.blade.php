<div class="card">
	<div class="card-header" id="heading{{ $id }}">
		<h5 class="mb-0">
			<button class="btn btn-link{{ isset($show)?'':' collapsed' }}" type="button" data-toggle="collapse" data-target="#collapse{{ $id }}" aria-expanded="{{ isset($show)?'true':'false' }}false" aria-controls="collapse{{ $id }}">
				{{ $title }}
			</button>
		</h5>
	</div>
	<div id="collapse{{ $id }}" class="collapse{{ isset($show)?' show':'' }}" aria-labelledby="heading{{ $id }}" data-parent="#{{ $parent }}">
		<div class="card-body">
			{{ $slot }}
		</div>
	</div>
</div>