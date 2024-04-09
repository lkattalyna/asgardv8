@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Memorias del servidor</h1>
    <hr>
@stop
@section('content')
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('memorias.index', $server->id) }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('memorias.store', $server->id) }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de asignación de  memoria al servidor</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="tipo" class="col-sm-2 control-label">Tipo:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option disabled selected>-Seleccione-</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cantidad" class="col-sm-2 control-label">Cantidad:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="cantidad" name="cantidad" type="number" pattern="^[0-9].{1,}" value="{{ old('cantidad') }}" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="capacidad" class="col-sm-2 control-label">Capacidad:</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="capacidad" name="capacidad" type="number" step="any" value="{{ old('capacidad') }}" pattern="^[0-9]{1,6}+(\,[0-9]{1,1})?$" required/>
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
