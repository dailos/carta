<div class="modal" id="{{ $id }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{{ $title}}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form :action="{{ $route }}" method="post">
				@csrf
				<div class="modal-body">
					{{ $slot }}
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>