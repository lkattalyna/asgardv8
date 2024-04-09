@extends('adminlte::page')
@section('content_header')
    <h1> Logs de inicio de sesión</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('loginLog-list')
        <div class="card card-default">
            <div class="card-body">
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
                <table id="example1" class="table table-striped table-bordered" style="width:100%" >
                    <thead>
                        <tr>
                            <th>Fecha_del_evento</th>
                            <th>username</th>
                            <th>email</th>
                            <th>ip</th>
                            <th>Dispositivo</th>
                            <th>Plataforma</th>
                            <th>Navegador</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at }}</td>
                                <td>{{ $log->username }}</td>
                                <td>{{ $log->email }}</td>
                                <td>{{ $log->ip }}</td>
                                <td>{{ $log->device }}</td>
                                <td>{{ $log->platform }}</td>
                                <td>{{ $log->browser }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th>username</th>
                            <th>email</th>
                            <td></td>
                            <th>Dispositivo</th>
                            <th>Plataforma</th>
                            <th>Navegador</th>
                        </tr>
                    </tfoot>
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
    @include('layouts.tableLongCF')
    <script>
        $(document).on('click','#download', function(e) { $('#cargando').modal('show'); });
    </script>
@stop
