@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Editar discos asignados</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('discos.index', $server->id) }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('discos.update', [$server->id, $disco->id]) }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        @method('PUT')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de edición de discos asignados</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="marca" class="col-sm-2 control-label">Marca:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="marca" name="marca" required>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}" @if($marca->id == $disco->id_disco_marca) selected @endif >{{ $marca->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cantidad" class="col-sm-2 control-label">Cantidad:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="cantidad" name="cantidad" type="number" pattern="^[0-9].{1,}" value="{{ $disco->cantidad }}" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="capacidad" class="col-sm-2 control-label">Capacidad:</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="capacidad" name="capacidad" type="number" step="any" value="{{ $disco->capacidad }}" pattern="^[0-9]{1,6}+(\,[0-9]{1,1})?$" required/>
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
