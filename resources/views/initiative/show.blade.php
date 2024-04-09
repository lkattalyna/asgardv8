@extends('adminlte::page')
@section('content_header')
    <h1> Automatización número {{ $initiative->id }}</h1><hr>
@stop
<!-- @section('plugins.Chartjs', true) -->
@section('content')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('initiative.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <!-- <td>{{$initiative->id}}</td> -->
                            
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos de la automatización</h3>
            </div>
            <div class="card-body">
            <div class="form-group">
                    <label>ID Iniciativa</label>
                    <p>{{ $initiative->id }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nombre de Iniciativa</label>
                    <p>{{ $initiative->initiative_name}}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nombre del Segmento</label>
                    <p>{{ $segment->name }}</p>
                    <hr>
                </div>
                
                <div class="form-group">
                    <label>Torre</label>
                    <p>{{ $service_layer->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Como</label>
                    <p> {{ $initiative->how }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Quiero</label>
                    <p> {{ $initiative->want }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Para</label>
                    <p> {{ $initiative->for }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tipo de tarea</label>
                    <p> {{ $initiative->task_type }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tipo de Automatización</label>
                    <p> {{ $initiative->automation_type }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Descripción General</label>
                    <p> {{ $initiative->general_description }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tiempo Manual de Ejecución</label>
                    <p> {{ $initiative->execution_time_manual }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Ventajas</label>
                    <p> {{ $initiative->advantages }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Archivo Adjunto</label>
                     <p> {{ $initiative->attachments }}</p>
                    <p><a href="{{ route('initiative.file',$initiative->attachments) }}" title="Ver documento" target="_blank">
                        <button class="btn btn-sm btn-default">
                            <i class="fa fa-eye" style="color: #0d6aad"></i>
                        </button>
                    </a></p>
                    <hr>
                </div>
                <!-- IMPRIME NOMBRE DE USUARIO DE REGISTRO DESDE BD -->
                <div class="form-group">
                    <label>Propietario ID</label>
                    <p> {{ $user->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <p> {{ $initiative->state }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Criterios de Aceptacion</label>
                    @foreach($criterias as $criteria)
                        <li>{{ $criteria->criterio }}</li>
                    @endforeach
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de Creación</label>
                    <p> {{ $initiative->created_at }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de Modificación</label>
                    <p> {{ $initiative->updated_at }}</p>
                    <hr>
                
            </div>
        </div>
        <div class="card card-default">
        <div class="card-body">
            <div class="float-sm-right">
                <a class="btn btn-sm btn-danger" href="{{ route('initiative.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    
@stop
@section('js')
    
@stop
