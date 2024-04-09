@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de roles</h1><hr>
@stop
@section('content')
    @can('rol-create')
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
        <form action="{{ route('roles.store') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de roles</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre del Rol:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,}" required  value="{{ old('name') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="col-sm-2 control-label">Comentario</label>
                        <div class="col-sm-10">
                            <textarea id="comment" name="comment" class="form-control" rows="3"
                            placeholder="Descripción del rol" maxlength="191">{{ old('comment') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="permisos" class="col-sm-2 control-label">Permisos:</label>
                        <div class="col-sm-10">
                            @foreach($permission as $value)
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="permisos{{ $value->id }}" name="permission[]" value="{{ $value->id }}">
                                    <label for="permisos{{ $value->id }}" class="custom-control-label">{{ $value->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
