@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de carpetas compartidas</h1><hr>
@stop
@section('content')
    @can('winShareFolder-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('winShareFolder.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('winShareFolder.store') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de carpetas compartidas</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Ruta:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text" maxlength="280"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/\=?^_`{|}~-].{1,280}" required  value="{{ old('name') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="permission" class="col-sm-2 control-label">Permisos:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="permission" name="permission" required>
                                <option value="Colaborador">Colaborador</option>
                                <option value="Lectura" selected>Lectura</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="group" class="col-sm-2 control-label">AD:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="group" name="group" type="text" maxlength="100"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,100}" required  value="{{ old('group') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="domain" class="col-sm-2 control-label">Dominio:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="domain" name="domain" type="text" maxlength="50"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,50}" required  value="{{ old('domain') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dc" class="col-sm-2 control-label">DC:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="dc" name="dc" type="text" maxlength="100"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,100}" required  value="{{ old('dc') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user" class="col-sm-2 control-label">Usuario:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="user" name="user" type="text" maxlength="120"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,120}" required  value="{{ old('user') }}"/>
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
