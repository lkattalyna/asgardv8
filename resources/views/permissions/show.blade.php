@extends('adminlte::page')
@section('content_header')
    <h1> Permiso: {{ $permission->name }}</h1><hr>
@stop
@section('content')
    @can('rol-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('permissions.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Datos del permiso</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre</label>
                    <p>{{ $permission->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Roles que tienen este permiso</label><br>
                    @if(!empty($rolesHasPermission))
                        @foreach($rolesHasPermission as $rol)
                            <p class="badge badge-secondary disabled">{{ $rol }},</p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
