@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Creación Sistemas Operativos</h1>
    <hr>
@stop

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('sistemaOperativo.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('sistemaOperativo.store') }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de creación de sistema operativo</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Sistema Operativo:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="name" name="name" type="text"
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
@stop
