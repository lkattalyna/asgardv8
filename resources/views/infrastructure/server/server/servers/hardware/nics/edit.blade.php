@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Editar NICs asignados</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('nics.index', $server->id) }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('nics.update', [$server->id, $nic->id]) }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        @method('PUT')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de edición de NICs asignados</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="referencia" class="col-sm-2 control-label">Referencia:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="referencia" name="referencia" required>
                            @foreach ($referencias as $referencia)
                                <option value="{{ $referencia->id }}" @if($referencia->id == $nic->id_nic_ref) selected @endif >{{ $referencia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cantidad" class="col-sm-2 control-label">Cantidad:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="cantidad" name="cantidad" type="number" pattern="^[0-9].{1,}" value="{{ $nic->cantidad }}" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="puertos" class="col-sm-2 control-label">Puertos:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="puertos" name="puertos" type="number" pattern="^[0-9].{1,}" value="{{ $nic->puertos }}" required/>
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
