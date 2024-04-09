@extends('adminlte::page')
@section('content')
    @can('executionLog-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('executionLogs.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>
                            ID de la tarea:
                        </td>
                        <td>
                            {{ $executionLog->id }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ID del JOB:
                        </td>
                        <td>
                            {{ $executionLog->id_job }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Fecha de ejecución en Asgard:
                        </td>
                        <td>
                            {{ $executionLog->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Fecha de inicio del script:
                        </td>
                        <td>
                            {{ $executionLog->d_ini_script }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Fecha de finalización del script:
                        </td>
                        <td>
                            {{ $executionLog->d_end_script }}
                        </td>
                    </tr>
                    @if($executionLog->elapsed != null)
                        <tr>
                            <td>
                                Duración de la ejecución del Playbook:
                            </td>
                            <td>
                                {{ $executionLog->elapsed }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            Estado:
                        </td>
                        <td>
                            @if($executionLog->status == 0)
                                <span class="badge badge-warning right">En proceso</span>
                            @elseif($executionLog->status >= 1 && $executionLog->status <= 9)
                                <span class="badge badge-success right">Finalizado</span>
                            @elseif($executionLog->status >= 11)
                                <span class="badge badge-danger right">Error</span>
                            @endif
                        </td>
                    </tr>
                    @if($executionLog->playbook != null)
                        <tr>
                            <td>
                                Nombre del Playbook:
                            </td>
                            <td>
                                {{ $executionLog->playbook }}
                            </td>
                        </tr>
                    @endif
                    @if($executionLog->id_template != null)
                        <tr>
                            <td>
                                ID del template:
                            </td>
                            <td>
                                {{ $executionLog->id_template }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            Responsable de la tarea:
                        </td>
                        <td>
                            {{ $executionLog->user }}
                        </td>
                    </tr>
                    @if($executionLog->status == 0 && $executionLog->id_job != null)
                        <tr>
                            <td>
                                Consultar estado de Job:
                            </td>
                            <td>
                            <a href="{{ route('ExecutionLog.getJobStatus',[$executionLog->id_job, $executionLog->id]) }}" title="Consultar estado">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-download " style="color: #0d6aad"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endif
                    @if ($executionLog->status > 0 && $executionLog->status != null)
                        @include('executionLogs.resultLayout')
                    @endif
                </table>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function(){
            //Cada 20 segundos (20000 milisegundos) se ejecutará la función refrescar
            var estado = {{ $executionLog->status }}
            if(estado == 0){
                setTimeout(refrescar, 20000);
            }

        });
        function refrescar(){
            //Actualiza la página
            $(location).attr('href',"{{ route('ExecutionLog.getJobStatus',[$executionLog->id_job, $executionLog->id]) }}");
        }
    </script>
@stop
