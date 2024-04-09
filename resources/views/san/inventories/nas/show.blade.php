@extends('adminlte::page')
@section('content_header')
    <h1> NAS {{ $sanNas->name }}</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('content')
    @can('sanNas-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanNas.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos de la NAS</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre de la NAS</label>
                    <p>{{ $sanNas->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Marca de la NAS</label>
                    <p>{{ $sanNas->trademark }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Modelo de la NAS</label>
                    <p>{{ $sanNas->model }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Serial de la NAS</label>
                    <p>{{ $sanNas->serial }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Codigo de servicio</label>
                    <p> {{ $sanNas->code }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>IP princial de la NAS</label>
                    <p>{{ $sanNas->main_ip }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>IP's Segundarias</label>
                    <p> {{ $sanNas->others_ip }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Ubicación</label>
                    <p> {{ $sanNas->location }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de soporte</label>
                    <p> {{ $sanNas->support_date }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado por</label>
                    <p> {{ $sanNas->owner->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado el</label>
                    <p> {{ $sanNas->created_at }}</p>
                    <hr>
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
