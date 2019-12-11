@if(is_array($ficha->fotos) )
<div id="carouselControls" class="carousel slide" data-ride="carousel" data-interval="false">
	<div class="carousel-inner">
		@isset($ficha->fotos['fotos'])
			@foreach ($ficha->fotos['fotos'] as $id)
				@if ($loop->first)
					<div class="carousel-item active">
				@else
					<div class="carousel-item">
				@endif
				<img class="d-block w-100" src="{{ url('fotos/' . $id) }}" alt="First slide">
				</div>
			@endforeach
		@endisset

		@isset($ficha->fotos['croquis'])
			@foreach ($ficha->fotos['croquis'] as $id)
			<div class="carousel-item">
				<img class="d-block w-100" src="{{ url('fotos/' . $id) }}" alt="First slide">
				<div class="carousel-caption d-none d-md-block">
					<p>Croquis</p>
				</div>
			</div>
			@endforeach
		@endisset
		
		<a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</div>
@endif
