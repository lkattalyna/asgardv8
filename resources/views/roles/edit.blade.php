@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de roles</h1><hr>
@stop
@section('content')
    @can('rol-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('roles.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('roles.update', $role->id) }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de edición de roles</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre del Rol:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text" value="{{ $role->name }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="col-sm-2 control-label">Comentario</label>
                        <div class="col-sm-10">
                            <textarea id="comment" name="comment" class="form-control" rows="3"
                            placeholder="Descripción del rol" maxlength="191">{{ $role->comment }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="permisos" class="col-sm-2 control-label">Permisos:</label>
                        <div class="col-sm-10">
                            @foreach($permission as $value)
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="permisos{{ $value->id }}" name="permission[]" value="{{ $value->id }}" @if(in_array($value->id, $rolePermissions)) checked @endif>
                                    <label for="permisos{{ $value->id }}" class="custom-control-label">{{ $value->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
