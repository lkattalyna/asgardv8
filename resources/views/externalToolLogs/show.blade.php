
@extends('adminlte::page')
@section('content')
    @can('externalToolLog-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('externalToolLogs.index') }}">
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
                            ID de la tarea en Asgard: 
                        </td>
                        <td>
                            {{ $externalToolLog->id }}
                        </td>
                    </tr>
                    @if(!is_null($externalToolLog->playbook))
                        <tr>
                            <td>
                                Nombre del Playbook:
                            </td>
                            <td>
                                {{ $externalToolLog->playbook }}
                            </td>
                        </tr>
                    @endif
                    @if(!is_null($externalToolLog->job_script))
                        <tr>
                            <td>
                                Nombre del script:
                            </td>
                            <td>
                                {{ $externalToolLog->job_script }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            Fecha de inicio del script:
                        </td>
                        <td>
                            {{ $externalToolLog->d_ini_script }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Fecha de finalización del script:
                        </td>
                        <td>
                            {{ $externalToolLog->d_end_script }}
                        </td>
                    </tr>
                    @if(!is_null($externalToolLog->elapsed))
                        <tr>
                            <td>
                                Duración de la ejecución del script:
                            </td>
                            <td>
                                {{ $externalToolLog->elapsed }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            Estado:
                        </td>
                        <td>
                            @if($externalToolLog->status == 0)
                                <span class="badge badge-warning right">En proceso</span>
                            @elseif($externalToolLog->status >= 1 && $externalToolLog->status <= 9)
                                <span class="badge badge-success right">Finalizado</span>
                            @elseif($externalToolLog->status >= 11)
                                <span class="badge badge-danger right">Error</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Responsable de la tarea:
                        </td>
                        <td>
                            {{ $externalToolLog->user }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Fecha de registro en Asgard:
                        </td>
                        <td>
                            {{ $externalToolLog->created_at }}
                        </td>
                    </tr>
                    @if ($externalToolLog->status > 0 && $externalToolLog->status != null)
                        @include('externalToolLogs.resultLayout')
                    @endif
                  
                </table>


                @if ($externalToolLog->status == 2 && $externalToolLog->status != null && $externalToolLog->job_script == "VmwareResourcesAdicionDiscos") 
                        <table class="table table-bordered table-hover">
                            <tr><td colspan= 3>Detalles de la ejecución:</td> <tr>                           
                            <tr>
                                <td>
                                Acción :
                                </td>
                                <td>
                                @if ($externalToolLog->job_script == "VmwareResourcesAdicionDiscos") 
                                Automatización Adición de discos duros
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                Detalle :
                                </td>
                                <td>
                                {{ $datosHistory[0]->valor_nuevo}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                Id del caso:
                                </td>
                                <td>
                                {{ $datosHistory[0]->id_caso}}
                                </td>
                            </tr>
                        </table>

                    @endif
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
