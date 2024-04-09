@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Servidores</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('servers.search') }}">
                    <span class="fa fa-search fa-1x"></span>&nbsp Buscar Servidor
                </a>
                <a class="btn btn-sm btn-danger" href="{{ route('servers.create') }}">
                    <span class="fa fa-plus fa-1x"></span>&nbsp Crear Nuevo Servidor
                </a>
            </div>
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>
    @include('layouts.messages')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Servidores registrados en el sistema</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Código de servicio</th>
                    <th>Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Data center</th>
                    <th>Site</th>
                    <th>Rack</th>
                    <th>Und inf</th>
                    <th>Und sup</th>
                    <th>Bahia</th>
                    <th>Cliente</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servers as $server)
                    <tr>
                    <td class="center">
                            <div class="btn-group">
                                <div class="input-group-btn">
                                    @can('recursos-run')
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Acciones
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('servers.show',$server->id)}}">Ver</a></li>
                                            <li class="divider"></li>
                                            @can('recursos-run')
                                                <!--<li><a href="{{ route('servers.edit',[$server->id,1])}}">Editar Datos Básicos</a></li>
                                                <li><a href="{{ route('servers.edit',[$server->id,2])}}">Editar Localización</a></li>
                                                <li><a href="{{ route('servers.edit',[$server->id,3])}}">Editar Cliente</a></li>
                                                <li><a href="{{ route('servers.edit',[$server->id,4])}}">Editar Datos de Servicio</a></li>
                                                <li><a href="{{ route('servers.edit',[$server->id,5])}}">Editar Soporte</a></li>
                                                <li><a href="{{ route('servers.edit',[$server->id,6])}}">Editar Hardware</a></li>-->
                                                <li><a href="{{ route('servers.edit',[$server->id,7])}}">Editar Firmware</a></li>
                                                <li class="divider"></li>
                                                <!--<li><a href="{{ route('servers.edit',[$server->id,8])}}">Cambiar Estado</a></li>
                                                <li class="divider"></li>-->
                                            @endcan
                                            @can('recursos-run')
                                                <!--<li> <a href="#" data-href="{{ route('servers.destroy',$server->id)}}" data-toggle="modal" data-target="#confirm-delete">Desistalar Servidor </a></li>
                                                <li class="divider"></li>-->
                                            @endcan
                                            @can('recursos-run')
                                                <!--<li><a href="{{ route('cpus.index',$server->id)}}">Agregar CPU</a></li>
                                                <li><a href="{{ route('discos.index',$server->id)}}">Agregar Disco</a></li>
                                                <li><a href="{{ route('hbas.index',$server->id)}}">Agregar HBA</a></li>
                                                <li><a href="{{ route('memorias.index',$server->id)}}">Agregar Memoria</a></li>
                                                <li><a href="{{ route('nics.index',$server->id)}}">Agregar NIC</a></li>
                                                <li class="divider"></li>-->
                                                <li><a href="{{ route('updateLogs.byServer',$server->id)}}">Update Fw Log</a></li>
                                            @endcan
                                        </ul>
                                    @endcan
                                </div>
                            </div>

                        </td>
                        <td>{{ $server->cod_servicio }}</td>
                        <td>{{ $server->serie }}</td>
                        <td>{{ $server->marca->nombre }}</td>
                        <td>{{ $server->modelo->modelo }} - {{ $server->generacion->generacion }}</td>
                        <td>{{ $server->dataCenter->nombre }}</td>
                        <td>{{ $server->site }}</td>
                        <td>{{ $server->rack }}</td>
                        <td>{{ $server->unidad_inferior }}</td>
                        <td>{{ $server->unidad_superior }}</td>
                        <td>{{ $server->bahia }}</td>
                        <td>{{ $server->cliente->nombre }}</td>

                    </tr>
                @endforeach
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
