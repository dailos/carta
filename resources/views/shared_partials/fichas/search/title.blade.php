<template v-if="busqueda_select == 'municipios'">
    <p>Puede seleccionar municipio y obtener todas sus fichas</p>
</template>

<template v-if="busqueda_select == 'simple'">
	<p>Para hacer búsquedas por palabras clave, sepárelas con espacios.</p>
</template>

<template v-if="busqueda_select == 'avanzada'">
	<p>Puede limitar sus búsquedas a un municipio, un grupo de actividades, un tipo o una actividad (agricultura, ganadería, hidraúlica, transporte...), incluyendo además palabras clave (pe. alpendre, cantonera, pozo, atalaya...).</p>
</template>

<template v-if="busqueda_select == 'acceso_directo'">
	<p>Si lo conoce, puede acceder directamente a la ficha de un bien introduciendo su número en el espacio destinado al efecto.</p>
</template>

<template v-if="busqueda_select == 'geo'">
	<p>Es posible realizar una búsqueda geográfica, seleccionando los bienes que se sitúan en un área determinada, para ello debe proporcionar un fichero de Google Earth, en formato .KML</p>
</template>

<template v-if="busqueda_select == 'geoprox'">
	<p>Es posible realizar una búsqueda por proximidad geográfica, selecionando un punto en el mapa (Haciendo click sobre él) y definiendo el alcance del area.</p>
</template>

<template v-if="busqueda_select == 'export'">
    <p>Es posible exportar todas las fichas en formato kml para su posterior conversión a diferentes formatos(shp, gis, dfx)</p>
</template>
