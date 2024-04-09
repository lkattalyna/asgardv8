@extends('adminlte::page')
@section('content_header')
    <h1> Documentación de la automatización # {{ $documentation->regImprovement->id }}</h1><hr>
@stop
@section('content')
    @can('documentation-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('documentations.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Segmento</label>
                    <p>{{ $documentation->regImprovement->serviceSegment->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Capa de servicio</label>
                    <p>{{ $documentation->regImprovement->serviceLayer->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Debe ser publicado en Asgard</label>
                    <p>@if($documentation->regImprovement->asgard == 0) No @else Si @endif</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <p>{{ $documentation->regImprovement->description }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Alcance</label>
                    <p> {{ $documentation->regImprovement->scope }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Objetivo</label>
                    <p> {{ $documentation->regImprovement->objetive }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tipo de automatización</label>
                    <p> {{ $documentation->regImprovement->aut_type }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tipo de tarea</label>
                    <p> {{ $documentation->regImprovement->task_type }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Periodo al que pertenece</label>
                    <p> {{ $documentation->regImprovement->start_date }} a {{ $documentation->regImprovement->end_date }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Entregable</label>
                    <p> {{ $documentation->regImprovement->deliverable }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nombre del playbook o automatización</label>
                    <p> {{ $documentation->regImprovement->playbook_name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Responsable de la automatización</label>
                    <p> {{ $documentation->regImprovement->owner->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de registro de la automatización</label>
                    <p> {{ $documentation->regImprovement->created_at }}</p>
                    <hr>
                </div>
                @if($documentation->regImprovement->approver_id != 0)
                    <div class="form-group">
                        <label>Automatización aprobada por</label>
                        <p> {{ $documentation->regImprovement->approver->name }}</p>
                        <hr>
                    </div>
                @endif
                <div class="form-group">
                    <label>Resultado esperado de la automatización</label>
                    <p> {{ $documentation->result }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Componentes de la automatización</label>
                    <p> {{ $documentation->components }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Servicios consumidos</label>
                    <p> {{ $documentation->consumedService->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Capas no relacionadas</label>
                    <p> {{ $documentation->unrelated_layers }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Contiene parámetros la automatización</label>
                    <p> @if($documentation->parameter_flag) Si @else No @endif</p>
                    <hr>
                </div>
                @if($documentation->parameter_flag)
                    <div class="form-group">
                        <label>Parámetros la automatización</label>
                        <p> {{ $documentation->parameters }}</p>
                        <hr>
                    </div>
                @endif
                <div class="form-group">
                    <label>Se incluye manual técnico</label>
                    <p> @if($documentation->tech_manual) Si @else No @endif</p>
                    <hr>
                </div>
                @if($documentation->tech_manual && $documentation->tech_manual_link != 'N/A' )
                    <div class="form-group">
                        <label>Manual técnico</label>
                        <p><a href="{{ route('documentations.file',$documentation->tech_manual_link) }}" title="Ver documento" target="_blank">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                            </button>
                        </a></p>
                        <hr>
                    </div>
                @elseif($documentation->tech_manual && $documentation->tech_manual_link == 'N/A' )
                    <div class="form-group">
                        <label>Manual técnico</label>
                        <p> El archivo no ha sido cargado aún</p>
                        <hr>
                    </div>
                @endif
                @if($documentation->user_manual_link != 'N/A' )
                    <div class="form-group">
                        <label>Manual de usuario final</label>
                        <p><a href="{{ route('documentations.userFile',$documentation->user_manual_link) }}" title="Ver documento" target="_blank">
                                <button class="btn btn-sm btn-default">
                                    <i class="fa fa-eye" style="color: #0d6aad"></i>
                                </button>
                            </a></p>
                        <hr>
                    </div>
                @endif
                <div class="form-group">
                    <label>Estado de aprobación de la documentación</label>
                    <p> @if($documentation->approval_status == 1) Aprobada @else Pendiente de aprobación @endif</p>
                    <hr>
                </div>
                @if($documentation->approver_id != 0)
                    <div class="form-group">
                        <label>Documentación aprobada por</label>
                        <p> {{ $documentation->approver->name }}</p>
                        <hr>
                    </div>
                @endif
                @if(!is_null($documentation->approval_date))
                    <div class="form-group">
                        <label>Documentación aprobada en la fecha</label>
                        <p> {{ $documentation->approval_date }}</p>
                        <hr>
                    </div>
                @endif
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
