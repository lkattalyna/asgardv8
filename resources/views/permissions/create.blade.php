@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de permisos</h1><hr>
@stop
@section('content')
    @can('rol-create')
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
        <form action="{{ route('permissions.store') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de permisos</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Nombre del permiso:</label>
                        <input class="form-control" id="name" name="name" type="text" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" required />
                    </div>
                    <div class="form-group">
                        <label for="permisos" class="control-label">Permisos básicos:</label>
                        <div class="col-sm-10">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos0" name="permission[]" value="-menu">
                                <label for="permisos0" class="custom-control-label">-menu</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos1" name="permission[]" value="-mixed">
                                <label for="permisos1" class="custom-control-label">-mixed</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos2" name="permission[]" value="-admin">
                                <label for="permisos2" class="custom-control-label">-admin</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos3" name="permission[]" value="-user">
                                <label for="permisos3" class="custom-control-label">-user</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos4" name="permission[]" value="-list">
                                <label for="permisos4" class="custom-control-label">-list</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos5" name="permission[]" value="-show">
                                <label for="permisos5" class="custom-control-label">-show</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos6" name="permission[]" value="-edit">
                                <label for="permisos6" class="custom-control-label">-edit</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos7" name="permission[]" value="-create">
                                <label for="permisos7" class="custom-control-label">-create</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos8" name="permission[]" value="-delete">
                                <label for="permisos8" class="custom-control-label">-delete</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permisos9" name="permission[]" value="-run">
                                <label for="permisos9" class="custom-control-label">-run</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Otro:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="new" name="new" type="text" value="{{ old('new') }}" maxlength="10"/>
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
