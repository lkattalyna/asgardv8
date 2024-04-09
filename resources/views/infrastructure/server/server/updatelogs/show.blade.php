@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Logs Actualización Firmware</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default ">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('updateLogs.byServer', $updateLog->id_server) }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header with-border">
            <h3 class="card-title">Datos del log de actualización de firmware</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-responsive">
                <tr>
                    <th>Marca del servidor</th>
                    <td colspan="2">{{ $updateLog->server->marca->nombre }}</td>
                </tr>
                <tr>
                    <th>Cambio Actualización</th>
                    <td colspan="2">{{ $updateLog->cambio }}</td>
                </tr>
                <tr>
                    <th>Modelo del servidor</th>
                    <td colspan="2">{{ $updateLog->server->modelo->modelo }} - {{ $updateLog->server->modelo->generacion }}</td>
                </tr>
                <tr>
                    <th>Código de servicio</th>
                    <td colspan="2">{{ $updateLog->server->cod_servicio }}</td>
                </tr>
                <tr>
                    <th>Serie del servidor</th>
                    <td colspan="2">{{ $updateLog->server->serie }}</td>
                </tr>
                <tr>
                    <th>Paquete de actualización</th>
                    <td colspan="2">{{ $updateLog->updatePack->nombre }}</td>
                </tr>
                <tr>
                    <th>Fecha de ejecución</th>
                    <td colspan="2">{{ $updateLog->created_at }}</td>
                </tr>
                <tr>
                    <th>Responsable de la ejecución</th>
                    <td colspan="2">{{ $updateLog->user->name }}</td>
                </tr>
                <tr>
                    <th class="text-center" colspan="3">Datos de la actualización</th>
                </tr>
                <tr>
                    <th class="text-center">Componente</th>
                    <th class="text-center">Versión anterior</th>
                    <th class="text-center">Versión nueva</th>
                </tr>
                <tr>
                    <th>Bios</th>
                    <td>{{ $updateLog->bios_fw_old }}</td>
                    <td>{{ $updateLog->bios_fw_new }}</td>
                </tr>
                <tr>
                    <th>Ilo</th>
                    <td>{{ $updateLog->ilo_fw_old }}</td>
                    <td>{{ $updateLog->ilo_fw_new }}</td>
                </tr>
                <tr>
                    <th>Controladora</th>
                    <td>{{ $updateLog->controladora_fw_old }}</td>
                    <td>{{ $updateLog->controladora_fw_new }}</td>
                </tr>
                <tr>
                    <th>Power Management</th>
                    <td>{{ $updateLog->pm_fw_old }}</td>
                    <td>{{ $updateLog->pm_fw_new }}</td>
                </tr>
                <tr>
                    <th>Nic</th>
                    <td>{{ $updateLog->nic_fw_old }}</td>
                    <td>{{ $updateLog->nic_fw_new }}</td>
                </tr>
                <tr>
                    <th>Hba</th>
                    <td>{{ $updateLog->hba_fw_old }}</td>
                    <td>{{ $updateLog->hba_fw_new }}</td>
                </tr>
                <tr>
                    <th>OA</th>
                    <td>{{ $updateLog->oa_fw_old }}</td>
                    <td>{{ $updateLog->oa_fw_new }}</td>
                </tr>
                <tr>
                    <th>VC Lan</th>
                    <td>{{ $updateLog->vc_lan_fw_old }}</td>
                    <td>{{ $updateLog->vc_lan_fw_new }}</td>
                </tr>
                <tr>
                    <th>VC San</th>
                    <td>{{ $updateLog->vc_san_fw_old }}</td>
                    <td>{{ $updateLog->vc_san_fw_new }}</td>
                </tr>


            </table>
        </div>
    </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
