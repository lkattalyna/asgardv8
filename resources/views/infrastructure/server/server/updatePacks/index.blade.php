@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Paquetes Actualización Firmware</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            @can('recursos-run')
                <div class="card-tools pull-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('updatePacks.create') }}">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Crear Nuevo Paquete de Actualización
                    </a>
                </div>
            @endcan
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>
    @include('layouts.messages')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Paquetes de actualización registrados en el sistema</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Generación</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($paquetes as $paquete)
                    <tr>
                        <td>{{ $paquete->marca->nombre }}</td>
                        <td>{{ $paquete->modelo->modelo }}</td>
                        <td>{{ $paquete->modelo->generacion }}</td>
                        <td>{{ $paquete->nombre }}</td>
                        <td>
                            @if($paquete->vigente == true)
                                <label class="badge badge-success">Vigente</label>
                            @else
                                <label class="badge badge-danger">Out of Date</label>
                            @endif
                        </td>
                        <td class="center">
                            <div class="btn-group">
                                <a href="{{ route('updatePacks.show',$paquete->id)}}" title="Ver">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                                @can('user-list')
                                    <a href="{{ route('updatePacks.edit',$paquete->id)}}" title="Editar">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-edit" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                @endcan
                                @can('user-list')
                                    <a href="#" title="Eliminar" data-href="{{route('updatePacks.destroy',$paquete->id)}}"
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
@endsection
