<script>
	$(document).ready( function () {
	    $('#{{ $table_id }}').DataTable({
	    	"language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "columnDefs": [
                {
                    "targets": [ {{ $column }} ],
                    "visible": false,
                    "searchable": false
                }
            ],
            createdRow: function ( row, data, index ) {
	            jQuery(row).click(function() {
	               showModeration(data[{{ $column }}]); 
	            });
	        },
	    });
	    function showModeration(route) {
	    	location.href=route;
	    }
	});
</script>