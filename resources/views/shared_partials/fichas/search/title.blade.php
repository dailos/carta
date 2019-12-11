<template v-if="busqueda_select == 'simple'">
	<h1>Búsqueda simple</h1>
	<p>Para hacer búsquedas por palabras clave, sepárelas con espacios.</p>
</template>

<template v-if="busqueda_select == 'avanzada'">
	<h1>Búsqueda avanzada</h1>
	<p>Puede limitar sus búsquedas a un municipio, un grupo de actividades, un tipo o una actividad (agricultura, ganadería, hidraúlica, transporte...), incluyendo además palabras clave (pe. alpendre, cantonera, pozo, atalaya...).</p>
</template>

<template v-if="busqueda_select == 'acceso_directo'">
	<h1>Acceso a las fichas</h1>
	<p>Si lo conoce, puede acceder directamente a la ficha de un bien introduciendo su número en el espacio destinado al efecto.</p>
</template>

<template v-if="busqueda_select == 'geo'">
	<h1>Búsqueda geográfica</h1>
	<p>Es posible realizar una búsqueda geográfica, seleccionando los bienes que se sitúan en un área determinada, para ello debe proporcionar un fichero de Google Earth, en formato .KML</p>
</template>

<template v-if="busqueda_select == 'geoprox'">
	<h1>Búsqueda próximidad geográfica</h1>
	<p>Es posible realizar una búsqueda por proximidad geográfica, selecionando un punto en el mapa (Haciendo click sobre él) y definiendo el alcance del area.</p>
</template>
