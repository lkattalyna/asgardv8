@extends('adminlte::page')
@section('content')
    @can('executionLog-show')
        <div class="card card-default">
            <div class="card-body">
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>
                            ID de la programación en Asgard:
                        </td>
                        <td>
                            {{ $jobSchedule->id }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ID de la programación en AWX:
                        </td>
                        <td>
                            {{ $jobSchedule->id_schedule }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ID del JOB:
                        </td>
                        <td>
                            {{ $jobSchedule->id_job }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Fecha de ejecución en Asgard:
                        </td>
                        <td>
                            {{ $jobSchedule->created_at }}
                        </td>
                    </tr>
                    @if($jobSchedule->id_template != null)
                        <tr>
                            <td>
                                ID del template:
                            </td>
                            <td>
                                {{ $jobSchedule->id_template }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            Responsable de la tarea:
                        </td>
                        <td>
                            {{ $jobSchedule->user->name }}
                        </td>
                    </tr>
                    @if(!is_null($jobSchedule->id_job))
                        <tr>
                            <td>
                                Consultar Job:
                            </td>
                            <td>
                            <a href="{{ route('executionLogs.show',$jobSchedule->id_ex_log) }}" title="Consultar job">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
