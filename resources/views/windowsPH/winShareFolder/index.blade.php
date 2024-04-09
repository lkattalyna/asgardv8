@extends('adminlte::page')
@section('content_header')
<h1> Consultar carpetas compartidas registradas</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('content')
    @can('winShareFolder-list')
        <div class="card card-default">
            <div class="card-body">
                @can('winShareFolder-create')
                    <a href="{{ route('winShareFolder.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nueva carpeta compartida
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Carpetas compartidas registradas en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre o Ruta</th>
                            <th>Permisos</th>
                            <th>Grupo</th>
                            <th>Dominio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->folder_name }}</td>
                                <td>{{ $item->permission }}</td>
                                <td>{{ $item->ad }}</td>
                                <td>{{ $item->domain }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        <a href="{{ route('winShareFolder.show',$item->id)}}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                        @can('winShareFolder-edit')
                                            <a href="{{ route('winShareFolder.edit',$item->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('winShareFolder-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('winShareFolder.destroy',$item->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
