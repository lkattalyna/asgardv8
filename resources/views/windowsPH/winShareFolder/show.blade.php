@extends('adminlte::page')
@section('content_header')
    <h1> Carpeta compartida</h1><hr>
@stop
@section('content')
    @can('winShareFolder-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('winShareFolder.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos de la carpeta compartida</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Ruta</label>
                    <p>{{ $winShareFolder->folder_name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Permisos</label>
                    <p> {{ $winShareFolder->permission }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>AD</label>
                    <p>{{ $winShareFolder->ad }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Dominio</label>
                    <p> {{ $winShareFolder->domain }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>DC</label>
                    <p>{{ $winShareFolder->dc }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Usuario</label>
                    <p> {{ $winShareFolder->user }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Creado el</label>
                    <p> {{ $winShareFolder->created_at }}</p>
                    <hr>
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
