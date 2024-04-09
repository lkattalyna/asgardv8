@extends('adminlte::page')
@section('content_header')
    <h1> Rol: {{ $role->name }}</h1><hr>
@stop
@section('content')
    @can('rol-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('roles.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Datos del Rol</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre</label>
                    <p>{{ $role->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <p>{{ $role->comment }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Permisos habilitados para el rol</label><br>
                    @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $v)
                            <p class="badge badge-secondary disabled">{{ $v->name }},</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="card-footer">
                @can('rol-edit')
                    <a class="btn btn-sm btn-danger" href="{{ route('roles.edit',$role->id)}}">
                        <i class="fa fa-edit"></i> Editar
                    </a>
                @endcan
                @if($role->id != 1)
                    @can('rol-delete')
                        <a class="btn btn-sm btn-danger" href="#" data-href="{{ route('roles.destroy',$role->id)}}" data-toggle="modal" data-target="#confirm-delete">
                            <i class="fa fa-trash"></i> Eliminar
                        </a>
                    @endcan
                @endif
            </div>
        </div>
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.justDelete')
@endsection
