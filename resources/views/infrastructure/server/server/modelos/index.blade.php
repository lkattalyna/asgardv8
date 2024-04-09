@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Modelos De Servidores</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            @can('recursos-run')
                <div class="card-tools pull-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('modelos.create') }}">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Crear Nuevo Modelo
                    </a>
                </div>
            @endcan
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>

    @include('layouts.messages')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Modelos registrados en el sistema</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Marca</th>
                    <th>Tipo</th>
                    <th>Modelo</th>
                    <th>Generación</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($modelos as $modelo)
                    <tr>
                        <td>{{ $modelo->id }}</td>
                        <td>{{ $modelo->marca->nombre }}</td>
                        <td>{{ $modelo->tipo }}</td>
                        <td>{{ $modelo->modelo }}</td>
                        <td>{{ $modelo->generacion }}</td>
                        <td class="center">
                            <div class="btn-group">
                                @can('recursos-run')
                                    <a href="{{ route('modelos.edit',$modelo->id)}}" title="Editar">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-edit" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                @endcan
                                @can('recursos-run')
                                    <a href="#" title="Eliminar" data-href="{{route('modelos.destroy',$modelo->id)}}"
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
