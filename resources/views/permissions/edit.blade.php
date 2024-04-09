@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de permisos</h1><hr>
@stop
@section('content')
    @can('rol-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('permissions.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('permissions.update', $permission->id) }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de edición de permisos</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre del permiso:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text" value="{{ $permission->name }}"
                                   pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" required/>
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
