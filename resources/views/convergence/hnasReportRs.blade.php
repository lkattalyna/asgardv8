@extends('adminlte::page')
@section('content_header')
    <h1> Reporte de depuración HNAS</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('virtualization-run')
    <div class="card card-default">
        <div class="card-body">
            <div class="float-sm-right">
                <a class="btn btn-sm btn-danger" href="{{ route('convergence.hnasReport')}}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3 class="card-title">Requerimientos pendientes de asignación</h3>
        </div>
        <!-- /.card-body -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table class="table table-striped table-bordered" >
                <tr>
                    <th>Espacio liberado</th>
                    <td>{{ $report->free_size }}</td>
                </tr>
                <tr>
                    <th>Espacio antes de ejecutar el proceso</th>
                    <td>{{ $report->size_before }}</td>
                </tr>
                <tr>
                    <th>Espacio despues de ejecutar el proceso</th>
                    <td>{{ $report->size_after }}</td>
                </tr>
                <tr>
                    <th>Fecha de inicio el script</th>
                    <td>{{ $report->start_time }}</td>
                </tr>
                <tr>
                    <th>Fecha de finalización el script</th>
                    <td>{{ $report->end_time }}</td>
                </tr>
                <tr>
                    <th>Total perfiles depurados</th>
                    <td>{{ $report->profiles }}</td>
                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    @if($report->has('users'))
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Perfiles depurados</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                    <tr>
                        <th>Espacio liberado</th>
                        <th>Directorio</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($report->users as $profile)
                        <tr>
                            <td>{{ $profile->size }}</td>
                            <td>{{ $profile->users }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif
    @if($report->has('usersDisabled'))
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table_b"></div>
            </div>
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Perfiles deshabilitados</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example2" class="table table-striped table-bordered" >
                    <thead>
                    <tr>
                        <th>Directorio</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($report->usersDisabled as $profile)
                        <tr>
                            <td>{{ $profile->users }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
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
            }).container().appendTo( '#btn_table_b' );
        });
    </script>
@stop
