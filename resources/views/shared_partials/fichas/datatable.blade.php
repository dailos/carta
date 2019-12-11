<script>
	$(function() {

		var tableColumnIndex = [];

	    var table = $('#{{ $table_id }}').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: {
	        	"url": "{!! $datatable_ajax !!}",
	        	"type": "POST",
	        	'headers': {
	        		'X-CSRF-TOKEN': '{{ csrf_token() }}'
	        	},
	        },
	        createdRow: function ( row, data, index ) {
	            jQuery(row).click(function() {
	               showFicha(data.id); 
	            });
	        },
	        columns: [
	            { data: 'foto', name: 'foto', orderable: false, searchable: false },
	            { data: 'cod_ficha', name: 'fichas.cod_ficha' },
	            { data: 'denominacion', name: 'fichas.denominacion' },
	            { data: 'actividad.nombre', name: 'actividad.nombre', defaultContent: '' },
	            { data: 'grupo.nombre', name: 'grupo.nombre', defaultContent: '' },
	            { data: 'tipo.nombre', name: 'tipo.nombre', defaultContent: '' },
	            { data: 'municipio.nombre', name: 'municipio.nombre', defaultContent: '' },
	            { data: 'localidad.nombre', name: 'localidad.nombre', defaultContent: '' },
                // Columnas ocultas para los filtros de búsqueda
	            { data: 'direccion', name: 'fichas.direccion', visible: false },
	            { data: 'isla_id', name: 'fichas.isla_id', visible: false },
	            { data: 'municipio_id', name: 'fichas.municipio_id', visible: false },
	            { data: 'localidad_id', name: 'fichas.localidad_id', visible: false },
	            { data: 'direccion', name: 'fichas.direccion', visible: false },
	            { data: 'cod_postal', name: 'fichas.cod_postal', visible: false },
	            { data: 'toponimias', name: 'fichas.toponimias', visible: false },
	            { data: 'actividad_id', name: 'fichas.actividad_id', visible: false },
	            { data: 'grupo_id', name: 'fichas.grupo_id', visible: false },
	            { data: 'tipo_id', name: 'fichas.tipo_id', visible: false },
	            { data: 'descripcion', name: 'fichas.descripcion', visible: false },
	            { data: 'historia', name: 'fichas.historia', visible: false },
	            { data: 'uso_actual_id', name: 'fichas.uso_actual_id', visible: false },
	            { data: 'estado_id', name: 'fichas.estado_id', visible: false },
	            { data: 'fragilidad_id', name: 'fichas.fragilidad_id', visible: false },
	            { data: 'valor_cientifico_id', name: 'fichas.valor_cientifico_id', visible: false },
	            { data: 'propiedad_id', name: 'fichas.propiedad_id', visible: false },
	            { data: 'clasificacion_suelo_id', name: 'fichas.clasificacion_suelo_id', visible: false },
	            { data: 'calificacion_suelo_id', name: 'fichas.calificacion_suelo_id', visible: false },
	            { data: 'nivel_proteccion', name: 'fichas.nivel_proteccion', visible: false },
	            { data: 'grado_proteccion_id', name: 'fichas.grado_proteccion_id', visible: false },
	            { data: 'sugerencias', name: 'fichas.sugerencias', visible: false },
	            { data: 'obs_generales', name: 'fichas.obs_generales', visible: false },
	            { data: 'contactos', name: 'fichas.contactos', visible: false },
                // Identificador de la ficha
	            { data: 'id', name: 'fichas.id', visible: false, searchable: false },
	        ],
	        "order": [[ 1, 'asc' ]],
	    	"language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
	    });

        // Creamos array con el mapeo de nombres de columna a índices para agilizar los accesos
	    var columns = table.settings().init().columns;
		
		for (i = 0; i < columns.length; i++) {
			tableColumnIndex[columns[i].name] = i;
		}

        // Eventos keyup para los filtros tipo input
		$(".filters").on('keyup', 'input', function() {
			table
        		.columns(tableColumnIndex['fichas.' + $(this).attr('id')])
        		.search( $(this).val() )
        		.draw();
		});

        // Eventos change para los filtros tipo select
		$(".filters").on('change', 'select', function() {
            if (this.value) {
    			// Usamos patrón para búsqueda exacta en identificadores. Por ejemplo: Que no devuelva '12' cuando queremos '2'
				table
	        		.columns(tableColumnIndex['fichas.' + $(this).attr('id')])
	        		.search("^" + this.value + "$", true, false, true)
	        		.draw();
        	} else {
        		table
	        		.columns(tableColumnIndex['fichas.' + $(this).attr('id')])
	        		.search(this.value)
	        		.draw();
        	}
		});

	    function showFicha(id) {
	    	location.href='{!! $datatable_view !!}/' + id;
	    }
    });

</script>