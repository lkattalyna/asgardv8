@extends('adminlte::page')
@section('content_header')
    <h1> Servidor {{ $sanServer->name }}</h1><hr>
@stop
@section('content')
    @can('sanServer-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanServer.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos del servidor</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre del servidor</label>
                    <p>{{ $sanServer->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Codigo de servicio</label>
                    <p> {{ $sanServer->code }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Serial del servidor</label>
                    <p>{{ $sanServer->serial }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Sistema operativo del servidor</label>
                    <p> {{ $sanServer->os }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>IP princial del servidor</label>
                    <p>{{ $sanServer->main_ip }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>IP's Segundarias</label>
                    <p> {{ $sanServer->others_ip }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Ubicación del servidor</label>
                    <p> {{ $sanServer->location }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Storage</label>
                    <p> {{ $sanServer->storage }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>memoria RAM del servidor</label>
                    <p> {{ $sanServer->memory }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Información adicional</label>
                    <p> {{ $sanServer->info }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado por</label>
                    <p> {{ $sanServer->owner->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado el</label>
                    <p> {{ $sanServer->created_at }}</p>
                    <hr>
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
