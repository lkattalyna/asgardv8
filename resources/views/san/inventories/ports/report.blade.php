@extends('adminlte::page')
@section('content_header')
<h1> Reporte de puertos registrados en el sistema</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('sanPort-list')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Puertos registrados en el sistema</h3>
                <div class="float-sm-right"><h6>Última actualización: {{ $log }}</h6></div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre del switch</th>
                            <th>Nombre del puerto</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                            <th>Slot</th>
                            <th>Puerto</th>
                            <th>IM</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

@section('js')
    <script>
        $(document).ready(function () {
            var table = $('#example1').DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ route('sanPorts.list') }}',
                    data: function (data) {
                        data.params = {
                            sac: "helo"
                        }
                    }
                },
                columns: [
                  {data: "sw", name: 'san_switches.sw', className: 'sw'},
                  {data: "name", className: 'name'},
                  {data: "service", className: 'service'},
                  {data: "status", className: 'status'},
                  {data: "slot", className: 'slot'},
                  {data: "port", className: 'port'},
                  {data: "im", className: 'im'},
                ],
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
            });
            $( '#btn_table' ).empty();
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
                    },{
                        extend: 'colvis',
                        text: 'Visualización',
                        className: 'btn btn-sm btn-default',
                    }
                ],
            }).container().appendTo( '#btn_table' );

            // fin create table
        });
    </script>
@endsection
