@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de servidor</h1><hr>
@stop
@section('plugins.Input-Mask', true)
@section('content')
    @can('sanServer-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanServer.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('sanServer.update', $sanServer->id) }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de edición de servidor</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre del servidor:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text" maxlength="40"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,40}" required  value="{{ $sanServer->name }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">Codigo de servicio:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="code" name="code" type="text" maxlength="30"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,30}" required  value="{{ $sanServer->code }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serial" class="col-sm-2 control-label">Serial del servidor:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="serial" name="serial" type="text" maxlength="20"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,20}" required  value="{{ $sanServer->serial }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="so" class="col-sm-2 control-label">Sistema operativo del servidor:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="so" name="so" type="text" maxlength="40"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,40}" required  value="{{ $sanServer->os }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ip"  class="col-sm-2 control-label">IP principal del servidor</label>
                        <div class="col-sm-10">
                            <input type="text" name="ip" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" value="{{ $sanServer->main_ip }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="other" class="col-sm-2 control-label">Ip's segundarias del servidor:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="other" name="other" type="text" maxlength="64"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,64}" required value="{{ $sanServer->others_ip }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location" class="col-sm-2 control-label">Ubicación:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="location" name="location" type="text" maxlength="50"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" required  value="{{ $sanServer->location }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="storage" class="col-sm-2 control-label">Storage:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="storage" name="storage" type="text" maxlength="50"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" required value="{{ $sanServer->storage }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="memory" class="col-sm-2 control-label">Memoria RAM del servidor:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="memory" name="memory" type="text" maxlength="10"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,10}"  required value="{{ $sanServer->memory }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="info" class="col-sm-2 control-label">Información adicional:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="info" name="info" maxlength="100"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,100}" required >{{ $sanServer->info }}
                            </textarea>
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
