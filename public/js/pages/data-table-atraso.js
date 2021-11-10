//[Data Table Javascript]

//Project:	Florence Admin - Responsive Admin Template
//Primary use:   Used only for the Data Table

$(function () {
    "use strict";

  // Setup - add a text input to each footer cell
				$('#example5 thead tr').clone(true).appendTo( '#example5 thead' );
				$('#example5 thead tr:eq(1) th').each( function (i) {
					var title = $(this).text();
					$(this).html( '<input type="text" style="width:95%!important" placeholder="Buscar '+title+'" />' );

					$( 'input', this ).on( 'keyup change', function () {
						if ( table.column(i).search() !== this.value ) {
							table
								.column(i)
								.search( this.value )
								.draw();
						}
					} );
				} );
			
	
	var table = $('#example5').DataTable( {
					"language": {
                        "sEmptyTable":   "Não foi encontrado nenhum registro",
                        "sLoadingRecords": "A carregar...",
                        "sProcessing":   "A processar...",
                        "sLengthMenu":   "Mostrar _MENU_ registros",
                        "sZeroRecords":  "Não foram encontrados resultados",
                        "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                        "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                        "sInfoPostFix":  "",
                        "sSearch":       "Procurar:",
                        "sUrl":          "",
                        "oPaginate": {
                            "sFirst":    "Primeiro",
                            "sPrevious": "Anterior",
                            "sNext":     "Seguinte",
                            "sLast":     "Último"
                        },
                        "oAria": {
                            "sSortAscending":  ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        },
                    },

                    "columnDefs": [{
                        "render": function(data){
                           return parseFloat(data).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                        }
                     }],

					order: [[ 4, "desc" ]],
					orderCellsTop: true,
				
					dom: 'Bfrtip',
						buttons: [
							'excelHtml5',
							'pdfHtml5'
						],
			} );
	
	
	
	
  }); // End of use strict