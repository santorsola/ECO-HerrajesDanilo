    <!-- DataTables core -->
    <script type="text/javascript" language="javascript" src="bootstrap/js/data_tables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="bootstrap/js/data_tables/dataTables.bootstrap.js"></script>
    <script type="text/javascript" language="javascript" src="bootstrap/js/data_tables/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript" src="bootstrap/js/data_tables/dataTables.tableTools.js"></script>

    <!-- css DataTables -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/data_tables/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/data_tables/dataTables.responsive.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/data_tables/dataTables.tableTools.css">
    



    <script type="text/javascript" charset="utf-8">
        
    $(document).ready(function() {

        $.extend( $.fn.dataTable.defaults, {
                        "language": {

                            "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún dato disponible en esta tabla",
                            "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_ registros filtrados",
                            "sInfoEmpty":      "Sin registros filtrados",
                            "sInfoFiltered":   "(Total _MAX_)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                        },

                        "oTableTools": {
                            "sSwfPath": "http://acccesoweb.com.ar/demo/swf/copy_csv_xls_pdf.swf",
                        },

                        dom:'<"arriba_der"f><"arriba_izq"l><"clear">rt<"abajo_der"pT><"abajo_izq"i><"clear">',
                        responsive: true} );



   
        // DataTable

        /*
        http://www.datatables.net/examples/api/multi_filter.html
            para grilla principales
            var table = $('#tbl').DataTable();

            para modales
            var table = $('#tblChild').DataTable({
                            "lengthMenu": [[10, 15, -1],[10, 15, "Todos"]]
                        });

        cambiar los anchos
         $('#tbl').DataTable( {
                      "columnDefs": [
                        { "width": "5%", "targets": 0}
                      ]
                    } );
        */
    } );


    </script>


