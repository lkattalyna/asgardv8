@extends('adminlte::page')
@section('content_header')
    <h1> Automatización proyectada número {{ $regImprovementMin->id }}</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('content')
    @can('regImprovement-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('regImprovementMin.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos de la automatización</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Segmento</label>
                    <p>{{ $regImprovementMin->serviceSegment->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Capa de servicio</label>
                    <p>{{ $regImprovementMin->serviceLayer->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <p>{{ $regImprovementMin->description }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nombre del playbook o automatización</label>
                    <p> {{ $regImprovementMin->playbook_name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Mes de entrega proyectado</label>
                    <p> {{ $regImprovementMin->end_month }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado por</label>
                    <p> {{ $regImprovementMin->owner->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>creado el</label>
                    <p> {{ $regImprovementMin->created_at }}</p>
                    <hr>
                </div>
                @if($regImprovementMin->improvement != 0)
                    <div class="form-group">
                        <label>Automatización tramitada con el registro</label>
                        <p><a href="{{ route('improvements.show',$regImprovementMin->improvement) }}" target="_blank" title="Consultar registro">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                            </button>
                        </a></p>
                        <hr>
                    </div>
                @endif
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
