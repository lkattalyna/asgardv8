@extends('adminlte::page')
@section('content_header')
    <h1> Switch {{ $sanSwitch->sw }}</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('content')
    @can('sanSwitch-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanSwitch.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos del switch</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Fabric al que pertenece</label>
                    <p>Fabric {{ $sanSwitch->fabric }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nombre del switch</label>
                    <p>{{ $sanSwitch->sw }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>IP del switch</label>
                    <p>{{ $sanSwitch->ip }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Dominio del switch</label>
                    <p> {{ $sanSwitch->domain }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Serial</label>
                    <p> {{ $sanSwitch->serial }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Codigo de servicio</label>
                    <p> {{ $sanSwitch->code }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fabricante</label>
                    <p> {{ $sanSwitch->maker }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Modelo</label>
                    <p> {{ $sanSwitch->model }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de soporte</label>
                    <p> {{ $sanSwitch->support_date }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Mac Address</label>
                    <p> {{ $sanSwitch->mac }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Uptime</label>
                    <p> {{ $sanSwitch->uptime }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado por</label>
                    <p> {{ $sanSwitch->owner->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado el</label>
                    <p> {{ $sanSwitch->created_at }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Actualizado el</label>
                    <p> {{ $sanSwitch->updated_at }}</p>
                    <hr>
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
