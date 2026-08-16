/*
 * Textos de DataTables en ingles.
 * Se carga despues de jquery.dataTables.min.js y sobrescribe los valores por
 * defecto de la libreria, para no tener que modificar el archivo minificado.
 */
$.extend(true, $.fn.dataTable.defaults, {
	language: {
		paginate: {
			first:    "First",
			last:     "Last",
			next:     "Next",
			previous: "Previous"
		},
		emptyTable:     "Select a grade",
		info:           "Showing _START_ to _END_ of _TOTAL_ records",
		infoEmpty:      "Showing 0 to 0 of 0 records",
		infoFiltered:   "(filtered from _MAX_ total records)",
		lengthMenu:     "Show _MENU_ records",
		loadingRecords: "Loading...",
		processing:     "Processing...",
		search:         "Search:",
		zeroRecords:    "No matching records found"
	}
});
