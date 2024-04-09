@extends('adminlte::page')
@section('content_header')
<h1 class="content-max-width">Servidor {{ $server->cod_servicio }}</h1>
    <hr>
@stop
@section('content')
    @can('recursos-run')
    <div class="card card-default ">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('servers.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
                <!--
                @can('recursos-run')
                    <a href="#" title="Eliminar" data-href="{{route('servers.destroy', $server->id)}}"
                       data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i> Eliminar
                    </a>
                @endcan-->
                @can('recursos-run')
                    <a href="{{ route('servers.edit',[$server->id,9])}}" title="Editar" data-href="#" >
                        <button class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i> Editar
                        </button>
                    </a>
                @endcan
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-solid card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Datos básicos</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Segmento</label><br>
                        {{ $server->servicio_macro }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Marca</label><br>
                        {{ $server->marca->nombre }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Modelo</label><br>
                        {{ $server->modelo->modelo  }} - {{$server->modelo->generacion}}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Código de servicio</label><br>
                        {{ $server->cod_servicio }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Serie</label><br>
                        {{ $server->serie }}
                        <hr>
                    </div>

                    <div class="form-group">
                        <label>Estado del servidor (Energía) </label><br>
                        {{ $server->estado }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Owner</label><br>
                        {{ $server->propietario->nombre }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Responsable</label><br>
                        {{ $server->responsable->nombre }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Sistema operativo</label><br>
                        {{ $server->so->nombre }}
                        <hr>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-solid card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Localización</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Data Center</label><br>
                        {{ $server->dataCenter->nombre }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Site</label><br>
                        {{ $server->site }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Rack</label><br>
                        {{ $server->rack }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Unidad Inferior</label><br>
                        {{ $server->unidad_inferior }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Unidad Superior</label><br>
                        {{ $server->unidad_superior }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Bahia</label><br>
                        {{ $server->bahia }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Dirección IP</label><br>
                        {{ $server->ip }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Observaciónes Equipo</label><br>
                        <textarea name="Observaciones" id="obs" cols="80" rows="5" readonly="false">{{ $server->observaciones}}</textarea>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-solid card-default" >
                <div class="card-header with-border">
                    <h3 class="card-title">Cliente</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Cliente</label><br>
                        {{ $server->cliente->nombre }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Cliente</label><br>
                        {{ $server->tipoCliente->nombre }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Hardware</label><br>
                        {{ $server->tipoHardware->nombre }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Servicio</label><br>
                        {{ $server->tipoServicio->nombre }}
                        <hr>
                    </div>
                    <!--<div class="form-group">
                        <label>Servicio Macro</label><br>
                        {{ $server->servicio_macro }}
                        <hr>
                    </div>-->
                    <div class="form-group">
                        <label>Tipo de Rack</label><br>
                        {{ $server->tipoRack->nombre }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Fecha Implementación</label><br>
                        {{ $server->fecha_Implementacion }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Fecha Desistalación</label><br>
                        {{ $server->fecha_Desistalacion }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Correos Contacto</label><br>
                        <textarea name="Correos" id="cor" cols="80" rows="5" readonly="false">{{ $server->correos }}</textarea>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-solid card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Soporte</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Tiene Soporte</label><br>
                        {{ $server->tiene_soporte }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Soporte</label><br>
                        {{ $server->tipo_soporte }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Soporte</label><br>
                        {{ $server->soporte }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>EOS DATE</label><br>
                        {{ $server->eos_date }}
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>EOL DATE</label><br>
                        {{ $server->eol_date }}
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-solid card-default">
        <div class="card-header with-border">
            <h3 class="card-title">Hardware</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Controladora</label><br>
                {{ $server->controladora->nombre }}
                <hr>
            </div>
            <div class="form-group">
                <label># de Fuentes</label><br>
                {{ $server->fuentes }}
                <hr>
            </div>
            <div class="form-group">
                <label>Raid</label><br>
                {{ $server->raid->tipo }}
                <hr>
            </div>
            <div class="form-group">
                <label>Unidad de Dvd</label><br>
                {{ $server->unidad_dvd }}
                <hr>
            </div>
            @if($server->cpus->isNotEmpty())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="3">CPUs</th>
                        </tr>
                        <tr>
                            <th>Marca Y Modelo del CPU</th>
                            <th>Cantidad</th>
                            <!--<th>Observación</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($server->cpus as $cpu)
                            <tr>
                                <td>{{ $cpu->modelo->marca->nombre }} - {{ $cpu->modelo->nombre }}</td>
                                <td>{{ $cpu->cantidad }}</td>
                                <!--<td>{{ $cpu->observacion }}</td>-->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            @endif
            @if($server->discos->isNotEmpty())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="3">Discos</th>
                        </tr>
                        <tr>
                            <th>Marca del disco</th>
                            <th>Cantidad</th>
                            <th>Capacidad</th>
                            <th>Numero De Parte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($server->discos as $disco)
                            <tr>
                                <td>{{ $disco->marca->nombre }}</td>
                                <td>{{ $disco->cantidad }}</td>
                                <td>{{ $disco->capacidad }}</td>
                                <td>{{ $disco->numeroParte }}</td>
                            </tr>
                            <tr>
                                <td>{{ $disco->marca->nombre }}</td>
                                <td>{{ $disco->cantidad_1 }}</td>
                                <td>{{ $disco->capacidad_1 }}</td>
                                <td>{{ $disco->numeroParte_1 }}</td>
                            </tr>
                            <tr>
                                <td>{{ $disco->marca->nombre }}</td>
                                <td>{{ $disco->cantidad_2 }}</td>
                                <td>{{ $disco->capacidad_2 }}</td>
                                <td>{{ $disco->numeroParte_2 }}</td>
                            </tr>
                            <tr>
                                <td>{{ $disco->marca->nombre }}</td>
                                <td>{{ $disco->cantidad_3 }}</td>
                                <td>{{ $disco->capacidad_3 }}</td>
                                <td>{{ $disco->numeroParte_3 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            @endif
            @if($server->hbas->isNotEmpty())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="2">HBAs</th>
                        </tr>
                        <tr>
                            <th>Puertos</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($server->hbas as $hba)
                            <tr>
                                <td>{{ $hba->puertos }}</td>
                                <td>{{ $hba->cantidad }}</td>
                            </tr>
                            <tr>
                                <td>{{ $hba->puertos_1 }}</td>
                                <td>{{ $hba->cantidad_1 }}</td>
                            </tr>
                            <tr>
                                <td>{{ $hba->puertos_2 }}</td>
                                <td>{{ $hba->cantidad_2 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            @endif
            @if($server->memorias->isNotEmpty())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="3">Memorias</th>
                        </tr>
                        <tr>
                            <th>Tipo de Memoria</th>
                            <th>Cantidad</th>
                            <th>Capacidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($server->memorias as $memoria)
                            <tr>
                                <td>{{ $memoria->tipo->nombre }}</td>
                                <td>{{ $memoria->cantidad }}</td>
                                <td>{{ $memoria->capacidad }} </td>
                            </tr>
                            <tr>
                                <td>{{ $memoria->tipo->nombre }}</td>
                                <td>{{ $memoria->cantidad_1 }}</td>
                                <td>{{ $memoria->capacidad_1 }} </td>
                            </tr>
                            <tr>
                                <td>{{ $memoria->tipo->nombre }}</td>
                                <td>{{ $memoria->cantidad_2 }}</td>
                                <td>{{ $memoria->capacidad_2 }} </td>
                            </tr>
                            <tr>
                                <td>{{ $memoria->tipo->nombre }}</td>
                                <td>{{ $memoria->cantidad_3 }}</td>
                                <td>{{ $memoria->capacidad_3 }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            @endif
            @if($server->nics->isNotEmpty())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="3">NICs</th>
                        </tr>
                        <tr>
                            <th>Referencia de la Nic</th>
                            <th>Cantidad</th>
                            <th>Puertos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($server->nics as $nic)
                            <tr>
                                <td>{{ $nic->referencia->nombre }}</td>
                                <td>{{ $nic->cantidad }}</td>
                                <td>{{ $nic->puertos }}</td>
                            </tr>
                            <tr>
                                <td>{{ $nic->referencia->nombre }}</td>
                                <td>{{ $nic->cantidad_1 }}</td>
                                <td>{{ $nic->puertos_1 }}</td>
                            </tr>
                            <tr>
                                <td>{{ $nic->referencia->nombre }}</td>
                                <td>{{ $nic->cantidad_2 }}</td>
                                <td>{{ $nic->puertos_2 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            @endif
        </div>
    </div>
    <div class="card card-solid card-default">
        <div class="card-header with-border">
            <h3 class="card-title">Firmware</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Firmware Bios</label><br>
                {{ $server->bios_firmware }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Nic </label><br>
                {{ $server->nic_firmware }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Ilo</label><br>
                {{ $server->ilo_firmware }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Controladora</label><br>
                {{ $server->controladora_firmware }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Power Management</label><br>
                {{ $server->power_management_firmware }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Hba</label><br>
                {{ $server->hba_firmware }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Oa</label><br>
                {{ $server->oa_firmware }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Virtual Connect San</label><br>
                {{ $server->vc_san }}
                <hr>
            </div>
            <div class="form-group">
                <label>Firmware Virtual Connect Lan</label><br>
                {{ $server->vc_lan }}
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

