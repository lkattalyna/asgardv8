<script>
    $(document).ready(function () {

        //$.fn.dataTable.ext.classes.sPageButton = ''; // Change Pagination Button Class
        if($("#order").length > 0){
            var order = $("#order").val();
        }else{
            var order = 'asc';
        }
        if($("#pos").length > 0){
            var pos = $("#pos").val();
        }else{
            var pos = 0;
        }
        var table = $('#example1').DataTable( {
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
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
            "order": [[ pos, order ]],
        });
        var table = $('#example2').DataTable( {
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
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
            "order": [[ pos, order ]],
        });
        // Cargar botones para acciones de exportar de datatables

        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copy',
                    text:'Copiar',
                    className: 'btn btn-sm btn-default',
                },{
                    extend: 'print',
                    text:'Imprimir',
                    //className: 'btn btn-sm btn-danger',
                    className: 'btn btn-sm btn-default',
                },{
                    extend: 'collection',
                    className: 'btn btn-sm btn-default',
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

    // Scrript para ejecutar el modal de confirmación de borrado

    $('#confirm-delete').on('show.bs.modal', function (e) {
        var formulario = createForm();
        function createForm() {
            var form =
                $('<form>', {
                    'method': 'POST',
                    'action': $(e.relatedTarget).data('href')
                });

            var token =
                $('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '<?php echo csrf_token(); ?>'
                });

            var hiddenInput =
                $('<input>', {
                    'name': '_method',
                    'type': 'hidden',
                    'value': 'DELETE'
                });

            return form.append(token, hiddenInput).appendTo('body');
        }
        $(this).find('.btn-ok').on('click', function () {
            formulario.submit();
        });
    });
</script>

