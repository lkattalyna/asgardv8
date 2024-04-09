@extends('adminlte::page')
@section('content_header')
<h1> Consultar grupos de usuarios</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('OsGroup-list')
        <div class="card card-default">
            <div class="card-body">
                @can('OsGroup-create')
                    <a href="{{ route('osGroups.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Grupo de Usuarios
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grupos de usuarios registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre del grupo</th>
                            <th>Inventario asociado</th>
                            <th>Mostrar a</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $grupo)
                            <tr>
                                <td>{{ $grupo->name }}</td>
                                <td>{{ $grupo->flag }}</td>
                                <td>{{ $grupo->show_to }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        @can('OsGroup-edit')
                                            <a href="{{ route('osGroups.edit',$grupo->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('OsGroup-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('osGroups.destroy',$grupo->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
@endsection
