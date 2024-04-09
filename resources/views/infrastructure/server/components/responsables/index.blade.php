@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Responsables Registrados</h1>
    <hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    <div class="card card-default">
        <div class="card-header">
            @can('recursos-run')
                <div class="card-tools pull-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('responsables.create') }}">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Crear Nuevo Responsable
                    </a>
                </div>
            @endcan
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>

    @include('layouts.messages')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Responsables registrados en el sistema</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Responsable</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($responsables as $responsable)
                    <tr>
                        <td>{{ $responsable->id }}</td>
                        <td>{{ $responsable->nombre }}</td>
                        <td class="center">
                            <div class="btn-group">
                                @can('recursos-run')
                                    <a href="{{ route('responsables.edit',$responsable->id)}}" title="Editar">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-edit" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                @endcan
                                @can('recursos-run')
                                    <a href="#" title="Eliminar" data-href="{{route('responsables.destroy',$responsable->id)}}"
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
@stop
@section('js')
    @include('layouts.tableFull')
@endsection
