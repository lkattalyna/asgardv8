@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Crear Modelos De Servidores</h1>
    <hr>
@stop
@section('content')
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('modelos.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('modelos.store') }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de creación de modelos</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="sector" class="col-sm-2 control-label">Marca a la que pertenece:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="marca" id="marca" required>
                            @foreach($marcas as $marca)
                                <option value="{{ $marca->id }}" >{{ $marca->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipo" class="col-sm-2 control-label">Tipo:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="tipo" id="tipo" required>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}" >{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                        <!--<input class="form-control" id="tipo" name="tipo" type="text"
                               pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" required/>-->
                    </div>
                </div>
                <div class="form-group">
                    <label for="modelo" class="col-sm-2 control-label">Modelo:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="modelo" name="modelo" type="text"
                               pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gen" class="col-sm-2 control-label">Generación:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="gen" name="gen" type="text"
                               pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" required/>
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
