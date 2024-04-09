<script>
    $(document).ready(function () {
        var table = $('#example1').dataTable( {
            //dom: 'Bfrtip',
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sUrl":            "",
                "sSearch":         "Buscar:",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "decimal": ",",
                "thousands": "."
            },
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching":   true,
        });
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copy',
                    text:'Copiar',
                    className: 'btn btn-sm',
                },{
                    extend: 'print',
                    text:'Imprimir',
                    className: 'btn btn-sm',
                },{
                    extend: 'collection',
                    className: 'btn btn-sm',
                    text: 'Exportar',
                    buttons: [
                        'csv',
                        'excel',
                        'pdf',
                    ]
                }
            ],
        }).container().appendTo( '#btn_table' );
        $("#cargando").fadeOut("slow");
    });
</script>

