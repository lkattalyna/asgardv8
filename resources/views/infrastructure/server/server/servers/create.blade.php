@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Servidores</h1>
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
    <form action="{{ route('servers.store') }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de creación de servidores</h3>
            </div>
            <div class="card-body">
                <div id="example-vertical">
                    <h3>Datos Básicos</h3>
                    <section>
                        <div class="form-group">
                            <label for="marca" class="col-sm-2 control-label">Marca:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="marca" id="marca" required>
                                    <option value="0">-Seleccione-</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="modelo" class="col-sm-2 control-label">Modelo:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="modelo" id="modelo" required>
                                    <option value="0">-Seleccione-</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cod_servicio" class="col-sm-2 control-label">Código de servicio:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="cod_servicio" name="cod_servicio" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="20" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="serie" class="col-sm-2 control-label">Serie:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="serie" name="serie" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="25" required/>
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="estado" class="col-sm-2 control-label">Estado del servidor :</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="estado" id="estado" required>
                                    <option value="Apagado">APAGADO</option>
                                    <option value="Encendido" selected>ENCENDIDO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="serverEstado" class="col-sm-2 control-label">Estado:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="serverEstado" id="serverEstado" required>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="propietario" class="col-sm-2 control-label">Owner:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="propietario" id="propietario" required>
                                    @foreach ($propietarios as $propietario)
                                        <option value="{{ $propietario->id }}">{{ $propietario->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="responsable" class="col-sm-2 control-label">Responsable:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="responsable" id="responsable" required>
                                    @foreach ($responsables as $responsable)
                                        <option value="{{ $responsable->id }}">{{ $responsable->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="so" class="col-sm-2 control-label">Sistema operativo:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="so" id="so" required>
                                    @foreach ($sos as $so)
                                        <option value="{{ $so->id }}">{{ $so->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </section>
                    <h3>Localización</h3>
                    <section>
                        <div class="form-group">
                            <label for="dataCenter" class="col-sm-2 control-label">Data center:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="dataCenter" id="dataCenter" required>
                                    @foreach ($dataCenters as $dataCenter)
                                        <option value="{{ $dataCenter->id }}">{{ $dataCenter->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site" class="col-sm-2 control-label">Site:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="site" name="site" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="30" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rack" class="col-sm-2 control-label">Rack:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="rack" name="rack" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="30" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="und_inferior" class="col-sm-2 control-label">Unidad inferior:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="und_inferior" name="und_inferior" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="und_superior" class="col-sm-2 control-label">Unidad superior:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="und_superior" name="und_superior" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bahia" class="col-sm-2 control-label">Bahia:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="bahia" name="bahia" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" maxlength="10" required/>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="ip" class="col-sm-2 control-label">Direccion IP:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="ip" name="ip" type="text" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" minlength="7" maxlength="15" size="15" required/>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="obs" class="col-sm-2 control-label">Observaciones:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="obs" id="obs" cols="30" rows="4"></textarea>
                            </div>
                        </div>
                    </section>
                    <h3>Cliente</h3>
                    <section>
                        <div class="form-group">
                            <label for="cliente" class="col-sm-2 control-label">Cliente:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="cliente" id="cliente" required>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipoCliente" class="col-sm-2 control-label">Tipo de cliente:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="tipoCliente" id="tipoCliente" required>
                                    @foreach ($tipoClientes as $tipoCliente)
                                        <option value="{{ $tipoCliente->id }}">{{ $tipoCliente->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fechaImplementacion" class="col-sm-2 control-label">Fecha Implementación:</label>
                            <div class="col-sm-10">
                                <input  class="form-control" type="date" name="fechaImplementacion" id="fechaImplementacion" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="correos" class="col-sm-2 control-label">Correos Contacto:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="email" id="email" cols="30" rows="4"></textarea>
                            </div>
                        </div>
                    </section>
                    <h3>Datos de servicio</h3>
                    <section>
                        <div class="form-group">
                            <label for="tipoHardware" class="col-sm-2 control-label">Tipo de hardware:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="tipoHardware" id="tipoHardware" required>
                                    @foreach ($tiposHardware as $tipoHardware)
                                        <option value="{{ $tipoHardware->id }}">{{ $tipoHardware->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipoServicio" class="col-sm-2 control-label">Tipo de servicio:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="tipoServicio" id="tipoServicio" required>
                                    @foreach ($tipoServicios as $tipoServicio)
                                        <option value="{{ $tipoServicio->id }}">{{ $tipoServicio->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="servicioMacro" class="col-sm-2 control-label">Segmento :</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="servicioMacro" id="servicioMacro" required>
                                    <option value="Datacenter" selected>E&N</option>
                                    <option value="IT">P&H</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipoRack" class="col-sm-2 control-label">Tipo de rack:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="tipoRack" id="tipoRack" required>
                                    @foreach ($tipoRacks as $tipoRack)
                                        <option value="{{ $tipoRack->id }}">{{ $tipoRack->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </section>
                    <h3>Soporte</h3>
                    <section>
                        <div class="form-group">
                            <label for="tieneSoporte" class="col-sm-2 control-label">Tiene soporte:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="tieneSoporte" id="tieneSoporte" required>
                                    <option value="No">NO</option>
                                    <option value="Si">SI</option>
                                    <option value="Sin Información"  selected >SIN INFORMACION</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipoSoporte" class="col-sm-2 control-label">Tipo de soporte:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="tipoSoporte" id="tipoSoporte" required>
                                    @foreach ($tipoSoportes as $tipoSoporte)
                                        <option value="{{ $tipoSoporte->tipo_soporte }}">{{ $tipoSoporte->tipo_soporte }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fechaSoporte" class="col-sm-2 control-label">Fecha de soporte:</label>
                            <div class="col-sm-10">
                                <input type="text" name="fechaSoporte" id="datepicker" class="form-control" value="{{ old('fechaSoporte') }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="eosDate" class="col-sm-2 control-label">EOS Date:</label>
                            <div class="col-sm-10">
                                <input type="text" name="eosDate" id="eosDate" class="form-control" value="{{ old('eosDate') }} " readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="eolDate" class="col-sm-2 control-label">EOL Date:</label>
                            <div class="col-sm-10">
                                <input type="text" name="eolDate" id="eolDate" class="form-control" value="{{ old('eolDate') }} " readonly>
                            </div>
                        </div>
                    </section>
                    <h3>Hardware</h3>
                    <section>
                        <div class="form-group">
                            <label for="controladora" class="col-sm-2 control-label">Controladora:</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="controladora" id="controladora" required>
                                    @foreach ($controladoras as $controladora)
                                        <option value="{{ $controladora->id }}">{{ $controladora->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="fuentes" class="col-sm-2 control-label">Numero de fuentes:</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="fuentes" name="fuentes" type="number" pattern="^[0-9]" placeholder="0" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="raid" class="col-sm-2 control-label">Raid:</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="raid" id="raid" required>
                                    @foreach ($raids as $raid)
                                        <option value="{{ $raid->id }}">{{ $raid->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="dvd" class="col-sm-2 control-label">Unidad DVD:</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="dvd" id="dvd" required>
                                    <option value="Si" selected>SI</option>
                                    <option value="No">NO</option>
                                    <option value="N/A">NO APLICA</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="proc" class="col-sm-2 control-label"># Procesador:</label>
                            <div class="col-sm-2">
                                <input class="form-control" id="proc" name="proc" type="number" pattern="^[0-9]" placeholder="0" required/>
                            </div>
                            <label for="marcaProc" class="col-sm-2 control-label">Marca Procesador :</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="marcaProc" id="marcaProc" required>
                                    @foreach ($cpuMarcas as $cpuMarca)
                                        <option value="{{ $cpuMarca->nombre }}">{{ $cpuMarca->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="modProc" class="col-sm-2 control-label">Modelo Procesador :</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="modProc" id="modProc" required>
                                    @foreach ($cpuModelos as $cpuModelo)
                                        <option value="{{ $cpuModelo->nombre }}">{{ $cpuModelo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="disco" class="col-sm-2 control-label"># Disco:</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="disco" name="disco" type="number" pattern="^[0-9]" placeholder="0" required/>
                            </div>
                            <label for="capDisco" class="col-sm-2 control-label">Capacidad Disco :</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="capDisco" id="capDisco" required>
                                    @foreach ($discoCapac as $capacidad)
                                        <option value="{{ $capacidad->capacidad }}">{{ $capacidad->capacidad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hba" class="col-sm-2 control-label"># Hba :</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="hba" name="hba" type="number" pattern="^[0-9]" placeholder="0" required/>
                            </div>
                            <label for="puerHba" class="col-sm-2 control-label">Puertos HBA :</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="puerHba" id="puerHba" required>
                                    @foreach ($hbas as $hba)
                                        <option value="{{ $hba->puertos }}">{{ $hba->puertos }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="memoria" class="col-sm-2 control-label"># Memoria :</label>
                            <div class="col-sm-2">
                                <input class="form-control" id="memoria" name="memoria" type="number" pattern="^[0-9]" placeholder="0" required/>
                            </div>
                            <label for="tipoMem" class="col-sm-2 control-label">Tipo Memoria :</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="tipoMem" id="tipoMem" required>
                                    @foreach ($memorias as $memoria)
                                        <option value="{{ $memoria->nombre }}">{{ $memoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="capMem" class="col-sm-2 control-label">Capacidad Memoria:</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="capMem" id="capMem" required>
                                    @foreach ($capMemorias as $capMemoria)
                                        <option value="{{ $capMemoria->capacidad }}">{{ $capMemoria->capacidad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nic" class="col-sm-2 control-label"># Nic :</label>
                            <div class="col-sm-2">
                                <input class="form-control" id="nic" name="nic" type="number" pattern="^[0-9]" placeholder="0" required/>
                            </div>
                            <label for="nic" class="col-sm-2 control-label">Nic Referencias :</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="nicRef" id="nicRef" required>
                                    @foreach ($nicReferencias as $nicReferencia)
                                        <option value="{{ $nicReferencia->nombre }}">{{ $nicReferencia->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="nicPuertos" class="col-sm-2 control-label">Puertos Nic :</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="nicPuertos" id="nicPuertos" required>
                                    @foreach ($nics as $nic)
                                        <option value="{{ $nic->puertos }}">{{ $nic->puertos }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </section>
                    <h3>Firmware</h3>
                    <section>
                        <div class="form-group">
                            <label for="biosFW" class="col-sm-2 control-label">Firmware Bios:</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="biosFW" name="biosFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                            <label for="nicFW" class="col-sm-2 control-label">Firmware Nic:</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="nicFW" name="nicFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="iloFW" class="col-sm-2 control-label">Firmware Ilo:</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="iloFW" name="iloFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                            <label for="controladoraFW" class="col-sm-2 control-label">Firmware Controladora:</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="controladoraFW" name="controladoraFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pmFW" class="col-sm-2 control-label">Firmware Power Management:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="pmFW" name="pmFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hbaFW" class="col-sm-2 control-label">Firmware Hba:</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="hbaFW" name="hbaFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                            <label for="oaFW" class="col-sm-2 control-label">Firmware Oa:</label>
                            <div class="col-sm-4">
                                <input class="form-control" id="oaFW" name="oaFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vcSanFW" class="col-sm-2 control-label">Firmware Virtual Connect San:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="vcSanFW" name="vcSanFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vcLanFW" class="col-sm-2 control-label">Firmware Virtual Connect Lan:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="vcLanFW" name="vcLanFW" type="text"pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="N/A" maxlength="50" required/>
                            </div>
                        </div>
                    </section>
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
@section('js')
    <script>
        $("#example-vertical").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            //stepsOrientation: "vertical",
            autoFocus: true
        });
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
                $.get('getModelos/'+marca, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    //console.log(data);
                    var modelo_select = '<option value="0">-Seleccione-</option>'
                    for (var i=0; i<data.length;i++)
                        modelo_select+='<option value="'+data[i].id+'">'+data[i].modelo+'-'+data[i].generacion+'</option>';

                    $("#modelo").html(modelo_select);

                });
            });
        });
    </script>
@stop
