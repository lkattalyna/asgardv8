@extends('adminlte::page')
@section('content_header')
    <h1> Logs de sincronización</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('loginLog-list')
        <div class="card card-default">
            <div class="card-body">
                <a class="btn btn-sm btn-danger" href="{{ route('syncLogs.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Logs registrados</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Fecha_del_evento</th>
                            <th>Tipo de reporte</th>
                            <th>Comentario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at }}</td>
                                <td>{{ $log->process }}</td>
                                <td>{{ $log->comment }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
