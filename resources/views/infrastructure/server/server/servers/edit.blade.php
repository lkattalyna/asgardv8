@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Editar datos de servidor</h1>
    <hr>
@stop
@section('content')
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('servers.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('servers.update', $server->id) }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        @method('PUT')
        <input type="hidden" name="form" value="{{ $form }}" >
        @switch($form)
            @case(1)
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Datos Básicos</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="marca" class="col-sm-2 control-label">Marca:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="marca" id="marca" required readonly>
                                <option value="0">-Seleccione-</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}" @if($marca->id == $server->id_marca) selected @endif>{{ $marca->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modelo" class="col-sm-2 control-label">Modelo:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="modelo" id="modelo" required readonly>
                                <option value="{{ $server->id_modelo }}">{{ $server->modelo->modelo }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cod_servicio" class="col-sm-2 control-label">Código de servicio:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="cod_servicio" name="cod_servicio" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="20" value="{{ $server->cod_servicio }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serie" class="col-sm-2 control-label">Serie:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="serie" name="serie" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="25" value="{{ $server->serie }}" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estado" class="col-sm-2 control-label">Estado del servidor:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="estado" id="estado" required>
                                <option value="Encendido" @if('ENCENDIDO' == $server->estado) selected @endif >ENCENDIDO</option>
                                <option value="Apagado" @if('APAGADO' == $server->estado) selected @endif >APAGADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="propietario" class="col-sm-2 control-label">Owner:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="propietario" id="propietario" required>
                                @foreach ($propietarios as $propietario)
                                    <option value="{{ $propietario->id }}" @if($propietario->id == $server->id_propietario) selected @endif >{{ $propietario->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="responsable" class="col-sm-2 control-label">Responsable:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="responsable" id="responsable" required>
                                @foreach ($responsables as $responsable)
                                    <option value="{{ $responsable->id }}" @if($responsable->id == $server->id_responsable) selected @endif >{{ $responsable->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="so" class="col-sm-2 control-label">Sistema operativo:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="so" id="so" required>
                                @foreach ($sos as $so)
                                    <option value="{{ $so->id }}" @if($so->id == $server->id_so) selected @endif >{{ $so->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @break
            @case(2)
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Localización</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="dataCenter" class="col-sm-2 control-label">Data center:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="dataCenter" id="dataCenter" required>
                                @foreach ($dataCenters as $dataCenter)
                                    <option value="{{ $dataCenter->id }}" @if($dataCenter->id == $server->id_data_center) selected @endif >{{ $dataCenter->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="site" class="col-sm-2 control-label">Site:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="site" name="site" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="30" value="{{ $server->site }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rack" class="col-sm-2 control-label">Rack:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="rack" name="rack" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="30" value="{{ $server->rack }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="und_inferior" class="col-sm-2 control-label">Unidad inferior:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="und_inferior" name="und_inferior" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" value="{{ $server->unidad_inferior }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="und_superior" class="col-sm-2 control-label">Unidad superior:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="und_superior" name="und_superior" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" value="{{ $server->unidad_superior }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bahia" class="col-sm-2 control-label">Bahia:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="bahia" name="bahia" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" value="{{ $server->bahia }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ip" class="col-sm-2 control-label">Direccion IP:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="ip" name="ip" type="text" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" minlength="7" maxlength="15" size="15" value="{{ $server->ip }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="obs" class="col-sm-2 control-label">Observaciones:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="obs" id="obs" type="text" maxlength="1500" value="{{ $server->observaciones }}" required>
                        </div>
                    </div>
                </div>
                @break
            @case(3)
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Cliente</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="cliente" class="col-sm-2 control-label">Cliente:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="cliente" id="cliente" required>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" @if($cliente->id == $server->id_cliente) selected @endif >{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipoCliente" class="col-sm-2 control-label">Tipo de cliente:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipoCliente" id="tipoCliente" required>
                                @foreach ($tipoClientes as $tipoCliente)
                                    <option value="{{ $tipoCliente->id }}" @if($tipoCliente->id == $server->id_tipo_cliente) selected @endif >{{ $tipoCliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="fechaImplementacion" class="col-sm-2 control-label">Fecha Implementación:</label>
                    <div class="col-sm-10">
                        <input  class="form-control" type="text" name="fechaImplementacion" id="fechaImplementacion" value="{{ $server->fecha_Implementacion }}" required>
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="fechaDesistalacion" class="col-sm-2 control-label">Fecha Desistalación:</label>
                    <div class="col-sm-10">
                        <input  class="form-control" type="text" name="fechaDesistalacion" id="fechaDesistalacion" value="{{ $server->fecha_Desistalacion }}" required>
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="correos" class="col-sm-2 control-label">Correos Contacto:</label>
                    <div class="col-sm-10">
                        <input  class="form-control" type="text" name="correos" id="correos" value="{{ $server->correos }}" required>
                    </div>
                    </div>
                </div>
                @break
            @case(4)
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Datos de Servicio</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="tipoHardware" class="col-sm-2 control-label">Tipo de hardware:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipoHardware" id="tipoHardware" required>
                                @foreach ($tiposHardware as $tipoHardware)
                                    <option value="{{ $tipoHardware->id }}" @if($tipoHardware->id == $server->id_tipo_hardware) selected @endif >{{ $tipoHardware->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipoServicio" class="col-sm-2 control-label">Tipo de servicio:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipoServicio" id="tipoServicio" required>
                                @foreach ($tipoServicios as $tipoServicio)
                                    <option value="{{ $tipoServicio->id }}" @if($tipoServicio->id == $server->id_tipo_servicio) selected @endif >{{ $tipoServicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="servicioMacro" class="col-sm-2 control-label">Segmento:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="segmento" id="segmento" required>
                                <option value="E&N" @if("E&N" == $server->servicio_macro) selected @endif >E&N</option>
                                <option value="P&H" @if("P&H" == $server->servicio_macro) selected @endif  >P&H</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipoRack" class="col-sm-2 control-label">Tipo de rack:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipoRack" id="tipoRack" required>
                                @foreach ($tipoRacks as $tipoRack)
                                    <option value="{{ $tipoRack->id }}" @if($tipoRack->id == $server->id_tipo_rack) selected @endif >{{ $tipoRack->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @break
            @case(5)
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Soporte</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="tieneSoporte" class="col-sm-2 control-label">Tiene soporte:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tieneSoporte" id="tieneSoporte" required>
                                <option value="No" @if("NO" == $server->tiene_soporte) selected @endif >NO</option>
                                <option value="Si" @if("SI" == $server->tiene_soporte) selected @endif >SI</option>
                                <option value="Sin Información" @if("SIN INFORMACION" == $server->tiene_soporte) selected @endif>SIN INFORMACION</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipoSoporte" class="col-sm-2 control-label">Tipo de soporte:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="tipoSoporte" name="tipoSoporte" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="190" value="{{ $server->tipo_soporte }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fechaSoporte" class="col-sm-2 control-label">Fecha de soporte:</label>
                        <div class="col-sm-10">
                        <input type="text" name="fechaSoporte" id="datepicker" class="form-control" value="{{ $server->soporte }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="eosDate" class="col-sm-2 control-label">EOS Date:</label>
                        <div class="col-sm-10">
                        <input type="text" name="eosDate" id="eosDate" class="form-control" value="{{ $server->eos_date }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="eolDate" class="col-sm-2 control-label">EOL Date:</label>
                        <div class="col-sm-10">
                        <input type="text" name="eolDate" id="eolDate" class="form-control" value="{{ $server->eol_date }}" readonly>
                        </div>
                    </div>
                </div>
                @break
            @case(6)
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Hardware</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="controladora" class="col-sm-2 control-label">Controladora:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="controladora" id="controladora" required>
                                @foreach ($controladoras as $controladora)
                                    <option value="{{ $controladora->id }}" @if($controladora->id == $server->id_controladora) selected @endif >{{ $controladora->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="fuentes" class="col-sm-2 control-label">Numero de fuentes:</label>
                        <div class="col-sm-4">
                        <input class="form-control" id="fuentes" name="fuentes" type="number" pattern="^[0-9]" placeholder="0" value="{{ $server->fuentes }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="raid" class="col-sm-2 control-label">Raid:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="raid" id="raid" required>
                                @foreach ($raids as $raid)
                                    <option value="{{ $raid->id }}" @if($raid->id == $server->id_raid) selected @endif >{{ $raid->tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="dvd" class="col-sm-2 control-label">Unidad DVD:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="dvd" id="dvd" required>
                                <option value="Si" @if("SI" == $server->unidad_dvd) selected @endif >SI</option>
                                <option value="No" @if("NO" == $server->unidad_dvd) selected @endif >NO</option>
                                <option value="N/A" @if("NO APLICA" == $server->unidad_dvd) selected @endif >NO APLICA</option>
                            </select>
                        </div>
                    </div>
                </div>
                @break
            @case(7)
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Firmware</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="biosFW" class="col-sm-2 control-label">Firmware Bios:</label>
                        <div class="col-sm-4">
                        <input class="form-control" id="biosFW" name="biosFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->bios_firmware }}" required/>
                        </div>
                        <label for="nicFW" class="col-sm-2 control-label">Firmware Nic:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="nicFW" name="nicFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->nic_firmware }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="iloFW" class="col-sm-2 control-label">Firmware Ilo:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="iloFW" name="iloFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->ilo_firmware }}" required/>
                        </div>
                        <label for="controladoraFW" class="col-sm-2 control-label">Firmware Controladora:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="controladoraFW" name="controladoraFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->controladora_firmware }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pmFW" class="col-sm-2 control-label">Firmware Power Management:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="pmFW" name="pmFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->power_management_firmware }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hbaFW" class="col-sm-2 control-label">Firmware Hba:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="hbaFW" name="hbaFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->hba_firmware }}" required/>
                        </div>
                        <label for="oaFW" class="col-sm-2 control-label">Firmware Oa:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="oaFW" name="oaFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->oa_firmware }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vcSanFW" class="col-sm-2 control-label">Firmware Virtual Connect San:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="vcSanFW" name="vcSanFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->vc_san }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vcLanFW" class="col-sm-2 control-label">Firmware Virtual Connect Lan:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="vcLanFW" name="vcLanFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->vc_lan }}" required/>
                        </div>
                    </div>
                </div>
                @break
            @case(8)
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Estado del Servidor</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Estado Actual:</label>
                        <div class="col-sm-4">
                            {{ $server->serverEstado->nombre }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serverEstado" class="col-sm-2 control-label">Estado:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="serverEstado" id="serverEstado" required>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}" @if($estado->id == $server->id_estado) selected @endif >{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @break
                @case(9)
                <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Datos Básicos</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="marca" class="col-sm-2 control-label">Marca:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="marca" id="marca" required readonly>
                                <option value="0">-Seleccione-</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}" @if($marca->id == $server->id_marca) selected @endif>{{ $marca->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modelo" class="col-sm-2 control-label">Modelo:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="modelo" id="modelo" required readonly>
                                <option value="{{ $server->id_modelo }}">{{ $server->modelo->modelo }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cod_servicio" class="col-sm-2 control-label">Código de servicio:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="cod_servicio" name="cod_servicio" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="20" value="{{ $server->cod_servicio }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serie" class="col-sm-2 control-label">Serie:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="serie" name="serie" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="25" value="{{ $server->serie }}" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estado" class="col-sm-2 control-label">Estado del servidor:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="estado" id="estado" required>
                                <option value="Encendido" @if('ENCENDIDO' == $server->estado) selected @endif >ENCENDIDO</option>
                                <option value="Apagado" @if('APAGADO' == $server->estado) selected @endif >APAGADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="propietario" class="col-sm-2 control-label">Owner:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="propietario" id="propietario" required>
                                @foreach ($propietarios as $propietario)
                                    <option value="{{ $propietario->id }}" @if($propietario->id == $server->id_propietario) selected @endif >{{ $propietario->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="responsable" class="col-sm-2 control-label">Responsable:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="responsable" id="responsable" required>
                                @foreach ($responsables as $responsable)
                                    <option value="{{ $responsable->id }}" @if($responsable->id == $server->id_responsable) selected @endif >{{ $responsable->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="so" class="col-sm-2 control-label">Sistema operativo:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="so" id="so" required>
                                @foreach ($sos as $so)
                                    <option value="{{ $so->id }}" @if($so->id == $server->id_so) selected @endif >{{ $so->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Localización</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="dataCenter" class="col-sm-2 control-label">Data center:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="dataCenter" id="dataCenter" required>
                                @foreach ($dataCenters as $dataCenter)
                                    <option value="{{ $dataCenter->id }}" @if($dataCenter->id == $server->id_data_center) selected @endif >{{ $dataCenter->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="site" class="col-sm-2 control-label">Site:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="site" name="site" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="30" value="{{ $server->site }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rack" class="col-sm-2 control-label">Rack:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="rack" name="rack" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="30" value="{{ $server->rack }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="und_inferior" class="col-sm-2 control-label">Unidad inferior:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="und_inferior" name="und_inferior" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" value="{{ $server->unidad_inferior }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="und_superior" class="col-sm-2 control-label">Unidad superior:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="und_superior" name="und_superior" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" value="{{ $server->unidad_superior }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bahia" class="col-sm-2 control-label">Bahia:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="bahia" name="bahia" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" value="{{ $server->bahia }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ip" class="col-sm-2 control-label">Direccion IP:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="ip" name="ip" type="text" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" minlength="7" maxlength="15" size="15" value="{{ $server->ip }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="obs" class="col-sm-2 control-label">Observaciones:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="obs" id="obs" type="text" maxlength="1500" value="{{ $server->observaciones }}" required>
                        </div>
                    </div>
                </div>
                <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Cliente</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="cliente" class="col-sm-2 control-label">Cliente:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="cliente" id="cliente" required>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" @if($cliente->id == $server->id_cliente) selected @endif >{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipoCliente" class="col-sm-2 control-label">Tipo de cliente:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipoCliente" id="tipoCliente" required>
                                @foreach ($tipoClientes as $tipoCliente)
                                    <option value="{{ $tipoCliente->id }}" @if($tipoCliente->id == $server->id_tipo_cliente) selected @endif >{{ $tipoCliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="fechaImplementacion" class="col-sm-2 control-label">Fecha Implementación:</label>
                    <div class="col-sm-10">
                        <input  class="form-control" type="text" name="fechaImplementacion" id="fechaImplementacion" value="{{ $server->fecha_Implementacion }}" required>
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="fechaDesistalacion" class="col-sm-2 control-label">Fecha Desistalación:</label>
                    <div class="col-sm-10">
                        <input  class="form-control" type="text" name="fechaDesistalacion" id="fechaDesistalacion" value="{{ $server->fecha_Desistalacion }}" required>
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="correos" class="col-sm-2 control-label">Correos Contacto:</label>
                    <div class="col-sm-10">
                        <input  class="form-control" type="text" name="correos" id="correos" value="{{ $server->correos }}" required>
                    </div>
                    </div>
                </div>
                <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Datos de Servicio</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="tipoHardware" class="col-sm-2 control-label">Tipo de hardware:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipoHardware" id="tipoHardware" required>
                                @foreach ($tiposHardware as $tipoHardware)
                                    <option value="{{ $tipoHardware->id }}" @if($tipoHardware->id == $server->id_tipo_hardware) selected @endif >{{ $tipoHardware->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipoServicio" class="col-sm-2 control-label">Tipo de servicio:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipoServicio" id="tipoServicio" required>
                                @foreach ($tipoServicios as $tipoServicio)
                                    <option value="{{ $tipoServicio->id }}" @if($tipoServicio->id == $server->id_tipo_servicio) selected @endif >{{ $tipoServicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="servicioMacro" class="col-sm-2 control-label">Segmento:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="segmento" id="segmento" required>
                                <option value="E&N" @if("E&N" == $server->servicio_macro) selected @endif >E&N</option>
                                <option value="P&H" @if("P&H" == $server->servicio_macro) selected @endif  >P&H</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipoRack" class="col-sm-2 control-label">Tipo de rack:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipoRack" id="tipoRack" required>
                                @foreach ($tipoRacks as $tipoRack)
                                    <option value="{{ $tipoRack->id }}" @if($tipoRack->id == $server->id_tipo_rack) selected @endif >{{ $tipoRack->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Soporte</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="tieneSoporte" class="col-sm-2 control-label">Tiene soporte:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tieneSoporte" id="tieneSoporte" required>
                                <option value="No" @if("NO" == $server->tiene_soporte) selected @endif >NO</option>
                                <option value="Si" @if("SI" == $server->tiene_soporte) selected @endif >SI</option>
                                <option value="Sin Información" @if("SIN INFORMACION" == $server->tiene_soporte) selected @endif>SIN INFORMACION</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipoSoporte" class="col-sm-2 control-label">Tipo de soporte:</label>
                        <div class="col-sm-10">
                        <input class="form-control" id="tipoSoporte" name="tipoSoporte" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="190" value="{{ $server->tipo_soporte }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fechaSoporte" class="col-sm-2 control-label">Fecha de soporte:</label>
                        <div class="col-sm-10">
                        <input type="text" name="fechaSoporte" id="datepicker" class="form-control" value="{{ $server->soporte }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="eosDate" class="col-sm-2 control-label">EOS Date:</label>
                        <div class="col-sm-10">
                        <input type="text" name="eosDate" id="eosDate" class="form-control" value="{{ $server->eos_date }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="eolDate" class="col-sm-2 control-label">EOL Date:</label>
                        <div class="col-sm-10">
                        <input type="text" name="eolDate" id="eolDate" class="form-control" value="{{ $server->eol_date }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Hardware</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="controladora" class="col-sm-2 control-label">Controladora:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="controladora" id="controladora" required>
                                @foreach ($controladoras as $controladora)
                                    <option value="{{ $controladora->id }}" @if($controladora->id == $server->id_controladora) selected @endif >{{ $controladora->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="fuentes" class="col-sm-2 control-label">Numero de fuentes:</label>
                        <div class="col-sm-4">
                        <input class="form-control" id="fuentes" name="fuentes" type="number" pattern="^[0-9]" placeholder="0" value="{{ $server->fuentes }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="raid" class="col-sm-2 control-label">Raid:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="raid" id="raid" required>
                                @foreach ($raids as $raid)
                                    <option value="{{ $raid->id }}" @if($raid->id == $server->id_raid) selected @endif >{{ $raid->tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="dvd" class="col-sm-2 control-label">Unidad DVD:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="dvd" id="dvd" required>
                                <option value="Si" @if("SI" == $server->unidad_dvd) selected @endif >SI</option>
                                <option value="No" @if("NO" == $server->unidad_dvd) selected @endif >NO</option>
                                <option value="N/A" @if("NO APLICA" == $server->unidad_dvd) selected @endif >NO APLICA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Firmware</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="biosFW" class="col-sm-2 control-label">Firmware Bios:</label>
                        <div class="col-sm-4">
                        <input class="form-control" id="biosFW" name="biosFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->bios_firmware }}" required/>
                        </div>
                        <label for="nicFW" class="col-sm-2 control-label">Firmware Nic:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="nicFW" name="nicFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->nic_firmware }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="iloFW" class="col-sm-2 control-label">Firmware Ilo:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="iloFW" name="iloFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->ilo_firmware }}" required/>
                        </div>
                        <label for="controladoraFW" class="col-sm-2 control-label">Firmware Controladora:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="controladoraFW" name="controladoraFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->controladora_firmware }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pmFW" class="col-sm-2 control-label">Firmware Power Management:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="pmFW" name="pmFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->power_management_firmware }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hbaFW" class="col-sm-2 control-label">Firmware Hba:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="hbaFW" name="hbaFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->hba_firmware }}" required/>
                        </div>
                        <label for="oaFW" class="col-sm-2 control-label">Firmware Oa:</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="oaFW" name="oaFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->oa_firmware }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vcSanFW" class="col-sm-2 control-label">Firmware Virtual Connect San:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="vcSanFW" name="vcSanFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->vc_san }}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vcLanFW" class="col-sm-2 control-label">Firmware Virtual Connect Lan:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="vcLanFW" name="vcLanFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" value="{{ $server->vc_lan }}" required/>
                        </div>
                    </div>
                </div>
                <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Estado del Servidor</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Estado Actual:</label>
                        <div class="col-sm-4">
                            {{ $server->serverEstado->nombre }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serverEstado" class="col-sm-2 control-label">Estado:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="serverEstado" id="serverEstado" required>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}" @if($estado->id == $server->id_estado) selected @endif >{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @break
        @endswitch
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
@section('js')
    <script>
        $(document).ready(function(){
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '2000/01/01',
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            });
            $('#eosDate').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '2000/01/01',
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            });
            $('#eolDate').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '2000/01/01',
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            });
            $("#marca").change(function(){
                var marca = $(this).val();
                $('#modelo').children('option').remove();
                $.get('../../getModelos/'+marca, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    //console.log(data);
                    var modelo_select = '<option value="0" disabled>-Seleccione-</option>'
                    for (var i=0; i<data.length;i++)
                        modelo_select+='<option value="'+data[i].id+'">'+data[i].modelo+'-'+data[i].generacion+'</option>';
                    $("#modelo").html(modelo_select);
                });
            });
        });
    </script>
@stop

