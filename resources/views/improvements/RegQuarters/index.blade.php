@extends('adminlte::page')
@section('content_header')
<h1> Consultar periodos</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('regQuarter-list')
        <div class="card card-default">
            <div class="card-body">
                @can('regQuarter-create')
                    <a href="{{ route('RegQuarters.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Periodo
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Periodos registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quarters as $quarter)
                            <tr>
                                <td>{{ $quarter->name }}</td>
                                <td>{{ $quarter->start_date }}</td>
                                <td>{{ $quarter->end_date }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        @can('regQuarter-edit')
                                            <a href="{{ route('RegQuarters.edit',$quarter->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('regQuarter-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('RegQuarters.destroy',$quarter->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
