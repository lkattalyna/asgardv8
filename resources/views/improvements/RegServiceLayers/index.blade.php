@extends('adminlte::page')
@section('content_header')
<h1> Consultar capas de servicio</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('content')
    @can('regServiceLayer-list')
        <div class="card card-default">
            <div class="card-body">
                @can('regServiceLayer-create')
                    <a href="{{ route('RegServiceLayers.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nueva Capa de Servicio
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Capas de servicio registradas en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Segmento</th>
                            <th>Modelo de negocio</th>
                            <th>Lider</th>
                            <th>Coordinador</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($layers as $layer)
                            <tr>
                                <td>{{ $layer->id }}</td>
                                <td>{{ $layer->name }}</td>
                                <td>{{ $layer->serviceSegment->name }}</td>
                                <td>{{ $layer->model }}</td>
                                <td>
                                    @if($layer->leader_id == 0)
                                        No Disponible
                                    @else
                                        {{ $layer->leader->name }}
                                    @endif
                                </td>
                                <td>
                                    @if($layer->coordinator_id == 0)
                                        No Disponible
                                    @else
                                        {{ $layer->coordinator->name }}
                                    @endif
                                </td>
                                <td class="center">
                                    <div class="btn-group">
                                        @can('regServiceLayer-edit')
                                            <a href="{{ route('RegServiceLayers.edit',$layer->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('regServiceLayer-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('RegServiceLayers.destroy',$layer->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
