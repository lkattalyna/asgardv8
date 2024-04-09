@extends('adminlte::page')
@section('content_header')
    <h1> Usuario: {{ $user->name }}</h1><hr>
@stop
@section('content')
    @can('user-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('users.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Username</label>
                    <p>{{ $user->username }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <p>{{ $user->email }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nivel</label>
                    <p>{{ $user->perfil }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <p>{{ $user->estado }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Usuario es desarrollador</label>
                    <p>
                        @if($user->developer == 1) Si @else No @endif
                    </p>
                    <hr>
                </div>
                @if(!is_null($user->last_login_at))
                    <div class="form-group">
                        <label>Ultimo login</label>
                        <p>{{ $user->last_login_at }}</p>
                        <hr>
                    </div>
                @endif
                @if(!is_null($user->last_login_ip))
                    <div class="form-group">
                        <label>Ultima IP del login</label>
                        <p>{{ $user->last_login_ip }}</p>
                        <hr>
                    </div>
                @endif
                <div class="form-group">
                    <label>Fecha de creación de usuario</label>
                    <p> {{ $user->created_at }}</p>
                    <hr>
                </div>
            </div>
        </div>
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.justDelete')
@stop
