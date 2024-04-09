@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Logs Actualizaciones Firmware</h1>
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
            </div>
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header with-border">
        <h3 class="card-title">Logs registrados en el sistema para el servidor {{ $server->cod_servicio }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Marca</th>
                    <th>Cambio</th>
                    <th>Modelo</th>
                    <th>Código de servicio</th>
                    <th>Serie</th>
                    <th>Paquete de actualización</th>
                    <th>Responsable</th>
                    <th>Fecha de ejecución</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->server->marca->nombre }}</td>
                        <td>{{ $log->cambio}}</td>
                        <td>{{ $log->server->modelo->modelo }} - {{ $log->server->modelo->generacion }}</td>
                        <td>{{ $log->server->cod_servicio }}</td>
                        <td>{{ $log->server->serie }}</td>
                        <td>{{ $log->updatePack->nombre }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->created_at }}</td>
                        <td class="center">
                            <div class="btn-group">
                                <a href="{{ route('updateLogs.view',[$log->id_server,$log->id])}}" title="Ver">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.card-body -->
        <div class="overlay" id="cargando"><!-- Animación Cargando -->
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div><!-- /.card -->
    @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
