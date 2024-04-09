@extends('adminlte::page')
@section('content_header')
<h1 class="content-max-width">Paquete de actualización {{ $updatePack->nombre }}</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default ">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('updatePacks.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
                @can('recursos-run')
                    <a href="#" title="Eliminar" data-href="{{route('updatePacks.destroy', $updatePack->id)}}"
                       data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i> Eliminar
                    </a>
                @endcan
            </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header with-border">
            <h3 class="card-title">Datos del paquete de actualización de firmware</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Marca - Modelo - Generación al que pertenece</label><br>
                {{ $updatePack->modelo->marca->nombre }} - {{ $updatePack->modelo->modelo }} - {{ $updatePack->modelo->generacion }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Bios</label><br>
                {{ $updatePack->bios_fw }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Nic </label><br>
                {{ $updatePack->nic_fw }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Ilo</label><br>
                {{ $updatePack->ilo_fw }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Controladora</label><br>
                {{ $updatePack->controladora_fw }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Power Management</label><br>
                {{ $updatePack->power_management_fw }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Hba</label><br>
                {{ $updatePack->hba_fw }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Oa</label><br>
                {{ $updatePack->oa_fw }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Virtual Connect San</label><br>
                {{ $updatePack->vc_san_fw }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Virtual Connect Lan</label><br>
                {{ $updatePack->vc_lan_fw }}
                <hr>
            </div>
        </div>
    </div>
    @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.justDelete')
@stop

