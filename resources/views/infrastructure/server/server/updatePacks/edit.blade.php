@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Editar Paquetes Actualización Firmware</h1>
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
    <form action="{{ route('updatePacks.update', $updatePack->id) }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        @method('PUT')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de edición de paquetes de actualización</h3>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 control-label">Nombre del paquete de actualización:</label>
                    <div class="col-sm-10">
                    <input class="form-control" id="nombre" name="nombre" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="SP-21245" value="{{ $updatePack->nombre }}" maxlength="30" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="modelo" class="col-sm-2 control-label">Modelo al que pertenece:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="modelo" id="modelo" required>
                            @foreach($modelos as $modelo)
                                <option value="{{ $modelo->id }}" @if($modelo->id == $updatePack->id_modelo) selected @endif >{{ $modelo->marca->nombre }} - {{ $modelo->modelo }} - {{ $modelo->generacion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="biosFW" class="col-sm-2 control-label">Firmware Bios:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="biosFW" name="biosFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->bios_fw }}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nicFW" class="col-sm-2 control-label">Firmware Nic:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="nicFW" name="nicFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->nic_fw }}" required/>
                    </div>
                    <label for="iloFW" class="col-sm-2 control-label">Firmware Ilo:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="iloFW" name="iloFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->ilo_fw }}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="controladoraFW" class="col-sm-2 control-label">Firmware Controladora:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="controladoraFW" name="controladoraFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->controladora_fw }}" required/>
                    </div>
                    <label for="pmFW" class="col-sm-2 control-label">Firmware Power Management:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="pmFW" name="pmFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->power_management_fw }}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="hbaFW" class="col-sm-2 control-label">Firmware Hba:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="hbaFW" name="hbaFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->hba_fw }}" required/>
                    </div>
                    <label for="oaFW" class="col-sm-2 control-label">Firmware Oa:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="oaFW" name="oaFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->oa_fw }}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="vcSanFW" class="col-sm-2 control-label">Firmware Virtual Connect San:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="vcSanFW" name="vcSanFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->vc_san_fw }}" required/>
                    </div>
                    <label for="vcLanFW" class="col-sm-2 control-label">Firmware Virtual Connect Lan:</label>
                    <div class="col-sm-4">
                        <input class="form-control" id="vcLanFW" name="vcLanFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="30" value="{{ $updatePack->vc_lan_fw }}"required/>
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
