<script>
 function createTable(name) {
            $(name).dataTable({

                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "scrollX": true,
            });
        }
    $(document).ready(function() {
        $('#host').select2({
            placeholder: "--Seleccione--",
            allowClear: true
        });

        $('#formfield').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
        });

        $('#sendForm').on('click', function(){
            swal({
                title: "¿Esta seguro?",
                text: "Esta completamente seguro de ejecutar la tarea con los parametros seleccionados",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["Cancelar", "Si, estoy seguro"],
            }).then((seguro) => {
                if (seguro) {
                    if($('#formfield')[0].checkValidity()){
                        $('#formfield').submit();
                    }else{
                        $('#formfield')[0].reportValidity();
                    }
                }
            });
        });
});

</script>
