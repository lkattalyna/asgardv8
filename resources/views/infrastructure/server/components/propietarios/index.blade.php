@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Propietarios Registrados</h1>
    <hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    <div class="card card-default">
        <div class="card-header">
            @can('recursos-run')
                <div class="card-tools pull-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('propietarios.create') }}">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Crear Nuevo Propietario
                    </a>
                </div>
            @endcan
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>

    @include('layouts.messages')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Propietarios registrados en el sistema</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Propietario</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($propietarios as $propietario)
                    <tr>
                        <td>{{ $propietario->id }}</td>
                        <td>{{ $propietario->nombre }}</td>
                        <td class="center">
                            <div class="btn-group">
                                @can('recursos-run')
                                    <a href="{{ route('propietarios.edit',$propietario->id)}}" title="Editar">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-edit" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                @endcan
                                @can('recursos-run')
                                    <a href="#" title="Eliminar" data-href="{{route('propietarios.destroy',$propietario->id)}}"
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
        </div>
    </div><!-- /.card -->
    @include('layouts.del_modal')
@stop
@section('js')
    @include('layouts.tableFull')
@endsection
