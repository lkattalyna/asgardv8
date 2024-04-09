@extends('adminlte::page')
@section('content_header')
<h1> Consultar LUNS registradas</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('sanLun-list')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">LUNS registradas en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Storage name</th>
                            <th>Storage type</th>
                            <th>Capacity</th>
                            <th>Devide ID</th>
                            <th>LUN name</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

@section('js')
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
                serverSide: true,
                ajax: {
                    url: '{{ route('sanLun.index')}}',
                },
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
                columns: [
                    {data: "service_code"},
                    {data: "type"},
                    {data: "size"},
                    {data: "device_id"},
                    {data: "name"}

                ]
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
        });
    </script>
@endsection
