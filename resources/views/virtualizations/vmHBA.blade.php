@extends('adminlte::page')
@section('content_header')
    <h1>Reporte de HBA virtual hosts</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('virtualization-user')

    <div class="card card-default">
        <div class="card-body">
            <div class="float-sm-right" id="btn_table"></div>
        </div>
    </div>
    @include('layouts.messages')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3 class="card-title">HBA's de virtual hosts registrados en el sistema</h3>
            <div class="float-sm-right"><h6>Última actualización: {{ $log }}</h6></div>
        </div>
        <!-- /.card-body -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-striped table-bordered" >
                <thead>
                    <tr>
                        <th>VM Host</th>
                        <th>Cluster</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Referencia</th>
                        <th>WWNN</th>
                        <th>WWPN</th>
                        <th>Firmware</th>
                        <th>Driver Name</th>
                        <th>Driver Version</th>
                        <th>Detalles</th>
                        <th>VID</th>
                        <th>DID</th>
                        <th>SVID</th>
                        <th>SSID</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vmHbas as $vmHba)
                        <tr>
                            <td>{{ $vmHba->vmHost->name }}</td>
                            <td>{{ $vmHba->vmHost->cluster }}</td>
                            <td>{{ $vmHba->name }}</td>
                            <td>{{ $vmHba->trademark }}</td>
                            <td>{{ $vmHba->reference }}</td>
                            <td>{{ $vmHba->wwnn }}</td>
                            <td>{{ $vmHba->wwpn }}</td>
                            <td>{{ $vmHba->firmware }}</td>
                            <td>{{ $vmHba->driver_name }}</td>
                            <td>{{ $vmHba->driver_version }}</td>
                            <td>{{ $vmHba->info }}</td>
                            <td>{{ $vmHba->vid }}</td>
                            <td>{{ $vmHba->did }}</td>
                            <td>{{ $vmHba->svid }}</td>
                            <td>{{ $vmHba->ssid }}</td>
                            <td style="text-align:center; ">
                                <a href="{{ route('virtualization.VMHostShow',$vmHba->id_vmhost) }}" target="_blank" title="Ver detalles">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Cluster</th>
                        <th colspan="13"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function () {
            var table = $('#example1').DataTable({
                initComplete: function () {
                    this.api().columns([1]).every( function () {
                        var column = this;
                        var select = $('<select><option value="">Todos</option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
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
