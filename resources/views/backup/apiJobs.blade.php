@extends('adminlte::page')
@section('content_header')
    <h1> Tabla de jobs ejecutados</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('backup-run')
        <div class="card card-default">
            <div class="card-header">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card overflow-auto" >
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Tabla de jobs ejecutados</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Estado Backup</th>
                            <th>ID Job</th>
                            <th>Razon</th>
                            <th>Nombre Backup</th>
                            <th>Tipo Backup</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prints['results'] as $data)
                            <tr>
                                <td>{{ $data['job']['destClientName'] }}</td>
                                <td>{{ $data['rescheduleStatus'] }}</td>
                                <td>{{ $data['jobId'] }}</td>
                                <td>{{ $data['reason'] }}</td>
                                <td>{{ $data['appTypeName'] }}</td>
                                <td>{{ $data['backupLevelName'] }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de descarga de validación de jobs commvault</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td colspan="2">
                            <legend>Datos básicos</legend>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <td>{{ $exec }}</td>
                            <a href="{{ route("backup.jobsRsFile","export.csv") }}"><button class="btn btn-large btn-danger"><i class="fa fa-download"></i> Descargar archivo de resultado</button></a>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
        @include('layouts.wait_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
    <script>
        $(document).on('click','#download', function(e) { $('#cargando').modal('show'); });
    </script>
@stop
