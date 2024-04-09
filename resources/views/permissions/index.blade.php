@extends('adminlte::page')
@section('content_header')
    <h1> Consultar roles</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('permission-list')
        <div class="card card-default">
            <div class="card-body">
                @can('permission-create')
                    <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevos Permisos
                    </a>
                @endcan
                <a href="{{ route('permissions.assign') }}" class="btn btn-sm btn-danger">
                    <span class="fa fa-arrow-right fa-1x"></span>&nbsp Asignar Permisos
                </a>
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permisos registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                    <tr>
                        <th>Nombre del permiso</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td class="center">
                                <div class="btn-group">
                                    @can('permission-show')
                                        <a href="{{ route('permissions.show',$permission->id)}}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('permission-edit')
                                        <a href="{{ route('permissions.edit',$permission->id)}}" title="Editar">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-edit" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('permission-delete')
                                        <a href="{{ route('permissions.revoke',$permission->id)}}" title="Quitar permiso a roles">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-minus-circle" style="color: #c51f1a"></i>
                                            </button>
                                        </a>
                                        <a href="#" title="Eliminar" data-href="{{route('permissions.destroy',$permission->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
