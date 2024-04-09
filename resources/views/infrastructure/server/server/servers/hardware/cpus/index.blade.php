@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">CPU asignada al servidor</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            @can('recursos-run')
                <div class="card-tools pull-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('cpus.create', $server->id) }}">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Asignar CPU
                    </a>
                    <a class="btn btn-sm btn-danger" href="{{ route('servers.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            @endcan
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>

    @include('layouts.messages')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">CPU asignados en el sistema</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Cantidad</th>
                    <th>Observación</th>
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tipos as $tipo)
                    <tr>
                        <td>{{ $tipo->modelo->marca->nombre }}</td>
                        <td>{{ $tipo->modelo->nombre }}</td>
                        <td>{{ $tipo->cantidad }}</td>
                        <td>{{ $tipo->observacion }}</td>
                        <td>{{ $tipo->created_at }}</td>
                        <td class="center">
                            <div class="btn-group">
                                @can('user-list')
                                    <a href="{{ route('cpus.edit',[$server->id,$tipo->id])}}" title="Editar">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-edit" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                @endcan
                                @can('user-list')
                                    <a href="#" title="Eliminar" data-href="{{route('cpus.destroy',[$server->id,$tipo->id]) }}"
                                       data-toggle="modal" data-target="#confirm-delete">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-trash" style="color: #c51f1a;"></i>
                                        </button>
                                    </a>
                                @endcan
                            </div>
                        </td>
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
    @include('layouts.tableFull')
@stop
