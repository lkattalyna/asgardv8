@extends('adminlte::page')
@section('content_header')
<h1> Consultar roles</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('rol-list')
        <div class="card card-default">
            <div class="card-body">
                @can('rol-create')
                    <a href="{{ route('roles.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Rol
                    </a>
                    <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevos Permisos
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Roles registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre del Rol</th>
                            <th>Descripción del Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->comment }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        @can('rol-show')
                                            <a href="{{ route('roles.show',$role->id)}}" title="Ver">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-eye" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('rol-edit')
                                            <a href="{{ route('roles.edit',$role->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @if($role->id != 1)
                                            @can('rol-delete')
                                                <a href="#" title="Eliminar" data-href="{{route('roles.destroy',$role->id)}}" data-toggle="modal" data-target="#confirm-delete">
                                                    <button class="btn btn-sm btn-default">
                                                        <i class="fa fa-trash" style="color: #c51f1a;"></i>
                                                    </button>
                                                </a>
                                            @endcan
                                        @endif
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
