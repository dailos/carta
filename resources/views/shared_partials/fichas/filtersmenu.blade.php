<div class="dropdown">
	<button type="button" id="dropdownMenuButton" class="btn btn-outline-secondary dropdown-toggle btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	Filtrar
	</button>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		<a class="dropdown-item" href="#" v-bind:class="{ active: filter == 'localizacion' }" v-on:click="filter == 'localizacion' ? filter = null :  filter = 'localizacion'">Localización</a>
		<a class="dropdown-item" href="#" v-bind:class="{ active: filter == 'clasificacion' }" v-on:click="filter == 'clasificacion' ? filter = null :  filter = 'clasificacion'">Clasificación</a>
		<a class="dropdown-item" href="#" v-bind:class="{ active: filter == 'estado' }" v-on:click="filter == 'estado' ? filter = null :  filter = 'estado'">Estado</a>
		<a class="dropdown-item" href="#" v-bind:class="{ active: filter == 'contactos' }" v-on:click="filter == 'contactos' ? filter = null :  filter = 'contactos'">Contactos</a>	
	</div>
</div>