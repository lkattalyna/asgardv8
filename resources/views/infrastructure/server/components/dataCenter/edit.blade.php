@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Editar Data Center</h1>
    <hr>
@stop
@section('content')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('dataCenter.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('dataCenter.update', $dataCenter->id) }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        @method('PUT')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de edición de data center</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Data Center:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="name" name="name" type="text" value="{{ $dataCenter->nombre }}"
                               pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="location" class="col-sm-2 control-label">Ubicación:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="location" name="location" type="text" value="{{ $dataCenter->ubicacion }}"
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
@stop
