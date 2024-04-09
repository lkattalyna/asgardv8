@extends('adminlte::page')
@section('content_header')
<h1> Consultar servicios consumidos</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('regConsumedService-list')
        <div class="card card-default">
            <div class="card-body">
                @can('regConsumedService-create')
                    <a href="{{ route('RegConsumedServices.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Servicio Consumido
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Servicios registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consumedServices as $consumedService)
                            <tr>
                                <td>{{ $consumedService->name }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        @can('regConsumedService-edit')
                                            <a href="{{ route('RegConsumedServices.edit',$consumedService->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('regConsumedService-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('RegConsumedServices.destroy',$consumedService->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
