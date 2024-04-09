@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">CPU del servidor</h1>
    <hr>
@stop
@section('content')
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('cpus.index', $server->id) }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('cpus.store', $server->id) }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de asignación de  CPU al servidor</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="marca" class="col-sm-2 control-label">Modelo:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="modelo" name="modelo" required>
                            <option disabled selected>-Seleccione-</option>
                            @foreach ($modelos as $modelo)
                                <option value="{{ $modelo->id }}">{{ $modelo->marca->nombre }} - {{ $modelo->nombre }}</option>
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
                    <label for="observacion" class="col-sm-2 control-label">Observación:</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="observacion" name="observacion" type="text" value="{{ old('observacion') }}" placeholder="N/A" maxlength="30"/>
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
