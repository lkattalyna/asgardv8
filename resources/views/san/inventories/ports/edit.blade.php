@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de puerto</h1><hr>
@stop
@section('content')
    @can('sanPort-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanPorts.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('sanPorts.update', $sanPort->id) }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de edición de puerto</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Switch al que pertenece:</label>
                        <div class="col-sm-10">
                            {{ $sanPort->getSwitch->sw }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nombre del puerto:</label>
                        <div class="col-sm-10">
                            {{ $sanPort->name }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Slot</label>
                        <div class="col-sm-10">
                            {{ $sanPort->slot }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Puerto</label>
                        <div class="col-sm-10">
                            {{ $sanPort->slot }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Estado</label>
                        <div class="col-sm-10">
                            {{ $sanPort->status }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Servicio</label>
                        <div class="col-sm-10">
                            {{ $sanPort->service }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="im" class="col-sm-2 control-label">IM:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="im" name="im" type="text" maxlength="15"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,15}" value="{{ $sanPort->im }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="col-sm-2 control-label">Observación:</label>
                        <div class="col-sm-10">
                            <textarea name="comment" id="comment" class="form-control" placeholder="Observación"
                                maxlength="300" rows="3" required>{{ $sanPort->comment }}</textarea>
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
