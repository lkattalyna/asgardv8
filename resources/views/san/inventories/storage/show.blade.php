@extends('adminlte::page')
@section('content_header')
    <h1> Storage {{ $sanStorage->name }}</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('content')
    @can('sanStorage-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanStorage.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos del storage</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre del storage</label>
                    <p>{{ $sanStorage->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Marca del storage</label>
                    <p>{{ $sanStorage->trademark }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Modelo del storage</label>
                    <p>{{ $sanStorage->model }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tipo del storage</label>
                    <p>{{ $sanStorage->type }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Serial del storage</label>
                    <p>{{ $sanStorage->serial }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Codigo de servicio</label>
                    <p> {{ $sanStorage->code }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>IP princial del storage</label>
                    <p>{{ $sanStorage->main_ip }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>IP's Segundarias</label>
                    <p> {{ $sanStorage->others_ip }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Ubicación</label>
                    <p> {{ $sanStorage->location }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Cache del storage</label>
                    <p> {{ $sanStorage->cache }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Procesador</label>
                    <p> {{ $sanStorage->processor }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>ID NAA</label>
                    <p> {{ $sanStorage->id_naa }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de soporte</label>
                    <p> {{ $sanStorage->support_date }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado por</label>
                    <p> {{ $sanStorage->owner->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado el</label>
                    <p> {{ $sanStorage->created_at }}</p>
                    <hr>
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
