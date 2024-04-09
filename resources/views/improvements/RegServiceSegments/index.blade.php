@extends('adminlte::page')
@section('content_header')
<h1> Consultar segmentos de servicio</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('regServiceSegment-list')
        <div class="card card-default">
            <div class="card-body">
                @can('regServiceSegment-create')
                    <a href="{{ route('RegServiceSegments.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Segmento de Servicio
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Segmentos de servicio registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Coordinador</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($segments as $segment)
                            <tr>
                                <td>{{ $segment->id }}</td>
                                <td>{{ $segment->name }}</td>
                                <td>
                                    @if($segment->coordinator_id == 0)
                                        No Disponible
                                    @else
                                        {{ $segment->coordinator->name }}
                                    @endif
                                </td>
                                <td class="center">
                                    <div class="btn-group">
                                        @can('regServiceSegment-edit')
                                            <a href="{{ route('RegServiceSegments.edit',$segment->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('regServiceSegment-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('RegServiceSegments.destroy',$segment->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
