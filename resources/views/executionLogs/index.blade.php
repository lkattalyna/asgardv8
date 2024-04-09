@extends('adminlte::page')
@section('content_header')
    <h1> Logs de ejecución</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('executionLog-list')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Logs de ejecución registrados en el sistema</h3>
            </div>
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Job</th>
                            <th>Playbook</th>
                            <th title="Fecha de ejecución en Asgard">Fecha EA</th>
                            <th title="Fecha de inicio del job en Ansible">Fecha IJA</th>
                            <th title="Fecha de finalización del job en Ansible">Fecha FJA</th>
                            <th>Estado</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->id_job }}</td>
                            @if ($log->playbook)
                                <td>{{ $log->playbook }}</td>
                            @else
                                <td>No Disponible</td>
                            @endif
                            <td>{{ $log->created_at }}</td>
                            <td>{{ $log->d_ini_script }}</td>
                            <td>{{ $log->d_end_script }}</td>
                            <td>
                                @if($log->status==0)
                                    <span class="badge badge-warning right">En proceso</span>
                                @elseif($log->status>=1 && $log->status<=9)
                                    <span class="badge badge-success right">Finalizado</span>
                                @elseif($log->status>=11)
                                    <span class="badge badge-danger right">Error</span>
                                @endif
                            </td>
                            <td>{{ $log->user }}</td>
                            <td>
                                <a href="{{ route('executionLogs.show', $log->id) }}" target="_blank" title="Ver Detalles">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <input type="hidden" name="order" id="order" value="desc">
            </div>
        </div>
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
         $(document).ready(function () {
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
                "order": [[ 0, "desc" ]],
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
        });

    </script>
@stop
