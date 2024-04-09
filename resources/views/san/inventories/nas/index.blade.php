@extends('adminlte::page')
@section('content_header')
<h1> Consultar NAS registradas</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('sanNas-list')
        <div class="card card-default">
            <div class="card-body">
                @can('sanNas-create')
                    <a href="{{ route('sanNas.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nueva NAS
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">NAS registradas en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>IP</th>
                            <th>Codigo de servicio</th>
                            <th>Serial</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->trademark }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->main_ip }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->serial }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        <a href="{{ route('sanNas.show',$item->id)}}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                        @can('sanNas-edit')
                                            <a href="{{ route('sanNas.edit',$item->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('sanNas-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('sanNas.destroy',$item->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
