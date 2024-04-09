@extends('adminlte::page')
@section('content_header')
    <h1> Logs de ejecución de herramientas externas</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('externalToolLog-list')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Logs de ejecución registrados en el sistema</h3>
            </div>
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th title="Fecha de inicio de la tarea en la herramienta">Fecha Inicio</th>
                            <th title="Fecha de finalización de la tarea en la herramienta">Fecha Finalización</th>
                            <th>Script</th>
                            <th>Estado</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->d_ini_script }}</td>
                            <td>{{ $log->d_end_script }}</td>
                            @if (!is_null($log->job_script))
                                <td>{{ $log->job_script }}</td>
                            @else
                                <td>No Disponible</td>
                            @endif
                            <td>
                                @if($log->status==0)
                                    <span class="badge badge-warning right">En proceso</span>
                                @elseif($log->status>=1 && $log->status<=9)
                                    <span class="badge badge-success right">Finalizado</span>
                                @elseif($log->status>=11)
                                    <span class="badge badge-danger right">Error</span>
                                @endif
                            </td>
                            <td>{{ $log->user }}</td>
                            <td>
                                <a href="{{ route('externalToolLogs.show', $log->id) }}" target="_blank" title="Ver Detalles">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <input type="hidden" name="order" id="order" value="desc">
            </div>
        </div>
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
