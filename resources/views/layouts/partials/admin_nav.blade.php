<div class="container">
	<div class="row align-items-center py-1">
		<div class="col-lg-4 col-md-4 py-1">
			<p class="title">Carta Etnográfica de Gran Canaria</p>
		</div>
		
		<div class="col-lg-2 col-md-2 col-sm-4 top-menu py-1">
			<a href="{{ route('admin.fichas.index') }}"><i class="fas fa-home"></i></a>
			<p>Fichas</p>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-4 top-menu py-1">
			<a href="{{ route('admin.configuracion.index') }}"><i class="fas fa-cogs"></i></a>
			<p>Configuración</p>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-4 top-menu py-1">
			<a href="#"><i class="fas fa-bell"></i></a>
		</div>

		<div class="col-lg-2 col-md-2 col-sm-12 col top-menu py-1">
			<div class="dropdown">
				<button type="button" class="btnmenu btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administrador</button>

				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="{{ route('profile.show') }}">Ver perfil</a>
					<a class="dropdown-item" href="{{ route('admin.moderacion.index') }}">Pendientes</a>
					<a class="dropdown-item" href="{{ route('admin.users.index') }}">Gestión de usuarios</a>
					<a class="dropdown-item" href="{{ route('logout') }}"
					   onclick="event.preventDefault();
					                 document.getElementById('logout-form').submit();">
					    Cerrar sesión
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					    @csrf
					</form>
				</div>
			</div>				
		</div>
	</div>
</div>