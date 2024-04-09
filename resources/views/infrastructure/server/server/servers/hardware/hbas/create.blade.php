@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">HBA del servidor</h1>
    <hr>
@stop
@section('content')
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('hbas.index', $server->id) }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('hbas.store', $server->id) }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de asignación de  HBA al servidor</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="cantidad" class="col-sm-2 control-label">Cantidad:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="cantidad" name="cantidad" type="number" pattern="^[0-9].{1,}" value="{{ old('cantidad') }}" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="puertos" class="col-sm-2 control-label">Puertos:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="puertos" name="puertos" type="number" pattern="^[0-9].{1,}" value="{{ old('puertos') }}" required/>
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
