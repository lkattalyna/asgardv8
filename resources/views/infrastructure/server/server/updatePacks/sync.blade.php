@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Sincronizar Paquetes Actualizaciones</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('updatePacks.search') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    <form action="{{ route('updateLogs.store') }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Sincronizar componente:</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <input type="hidden" name="servidor" value="{{ $server->id }}">
                <input type="hidden" name="update" value="{{ $updatePack->id }}">

                    <table class="table table-bordered">
                        <tr>
                            <td>Servidor:</td>
                            <td>{{ $server->cod_servicio }}</td>
                        </tr>
                        <tr>
                            <td>Serial:</td>
                            <td>{{ $server->serie }}</td>
                        </tr>
                        <tr>
                            <td>Paquete de actualización:</td>
                            <td>{{ $updatePack->nombre }}</td>
                        </tr>
                        <tr>
                            <td rowspan="6">Items</td>
                            <td><input type="checkbox" id="componentes" name="componentes[]" value="bios"> Bios</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id="componentes" name="componentes[]" value="ilo"> Ilo</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id="componentes" name="componentes[]" value="controladora"> Controladora</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id="componentes" name="componentes[]" value="pm"> Power Management</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id="componentes" name="componentes[]" value="nic"> Nic</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id="componentes" name="componentes[]" value="hba"> Hba</td>
                        </tr>
                        <!--
                        <tr>
                            <td><input type="checkcard" id="componentes" name="componentes[]" value="oa"> OA</td>
                        </tr>
                        <tr>
                            <td><input type="checkcard" id="componentes" name="componentes[]" value="vc_lan"> VC Lan</td>
                        </tr>
                        <tr>
                            <td><input type="checkcard" id="componentes" name="componentes[]" value="vc_san"> VC San</td>
                        </tr>
                        -->
                        <tr>
                            <td>Cambio Historico</td>
                            <td>{{ $server->rfc_firmware }}</td>
                        </tr>
                        <tr>
                            <td>Fecha Cambio Anterior</td>
                            <td>{{ $server->actualizado_firmware }}</td>
                        </tr>
                        <tr>
                            <td>Cambio Actualización:</td>
                            <td><input type="text" id="cambio" name="cambio" required  placeholder="No Cambio De Actualización "></td>
                        </tr>

                        <tr>
                            <th class="text-center" colspan="3">Datos de la actualización</th>
                        </tr>
                        <tr>
                            <th class="text-center">Componente</th>
                            <th class="text-center">Versión Servidor</th>
                            <th class="text-center">Versión Paquete</th>
                        </tr>
                        <tr>
                            <th>Bios</th>
                            <td>{{ $server->bios_firmware }}</td>
                            <td>{{ $updatePack->bios_fw }}</td>
                        </tr>
                        <tr>
                            <th>Ilo</th>
                            <td>{{ $server->ilo_firmware }}</td>
                            <td>{{ $updatePack->ilo_fw }}</td>
                        </tr>
                        <tr>
                            <th>Controladora</th>
                            <td>{{ $server->controladora_firmware }}</td>
                            <td>{{ $updatePack->controladora_fw }}</td>
                        </tr>
                        <tr>
                            <th>Power Management</th>
                            <td>{{ $server->power_management_firmware }}</td>
                            <td>{{ $updatePack->power_management_fw }}</td>
                        </tr>
                        <tr>
                            <th>Nic</th>
                            <td>{{ $server->nic_firmware }}</td>
                            <td>{{ $updatePack->nic_fw }}</td>
                        </tr>
                        <tr>
                            <th>Hba</th>
                            <td>{{ $server->hba_firmware }}</td>
                            <td>{{ $updatePack->hba_fw }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div><!-- /.card -->
    </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
