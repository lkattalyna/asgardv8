@extends('adminlte::page')
@section('content_header')
    <h1> VM Host {{ $vmHost->name }}</h1><hr>
@stop
@section('content')
    @can('virtualization-user')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('virtualization.VMHostReport') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <!-- /card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos del host</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre</label>
                    <p>{{ $vmHost->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>VCenter</label>
                    <p>{{ $vmHost->vcenter }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Vendor</label>
                    <p>{{ $vmHost->vendor }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Codigo de servicio</label>
                    <p>{{ $vmHost->service_code }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>IP</label>
                    <p>{{ $vmHost->ip }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Memoria</label>
                    <p>{{ $vmHost->memory }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>CPU</label>
                    <p>{{ $vmHost->cpu }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Capacidad total de disco</label>
                    <p>{{ $vmHost->total_disk }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Versión EXSI</label>
                    <p>{{ $vmHost->exci_version }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Power State</label>
                    <p>{{ $vmHost->power_state }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Connection State</label>
                    <p>{{ $vmHost->connection_state }}</p>
                    <hr>
                </div>
                @if(!is_null($vmHost->created_at))
                    <div class="form-group">
                        <label>Fecha de creación</label>
                        <p> {{ $vmHost->created_at }}</p>
                        <hr>
                    </div>
                @endif
                @if(!is_null($vmHost->created_at))
                    <div class="form-group">
                        <label>Fecha de creación</label>
                        <p> {{ $vmHost->created_at }}</p>
                        <hr>
                    </div>
                @endif
            </div>
        </div>
        <div class="card with-border">
            <div class="card-header">
                <h3 class="card-title">HBA's registradas para el Vm Host</h3>
            </div>
            <div class="card-body">
                @if($vmHost->vmHbas->count() > 0)
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Referencia</th>
                            <th>WWNN</th>
                            <th>WWPN</th>
                            <th>Firmware</th>
                            <th>Driver Name</th>
                            <th>Driver Version</th>
                            <th>Detalles</th>
                            <th>VID</th>
                            <th>DID</th>
                            <th>SVID</th>
                            <th>SSID</th>
                            <th title="Consultar Compatibilidad">CC</th>
                        </tr>
                        @foreach($vmHost->vmHbas as $vmHba)
                            <tr>
                                <td>{{ $vmHba->name }}</td>
                                <td>{{ $vmHba->trademark }}</td>
                                <td>{{ $vmHba->reference }}</td>
                                <td>{{ $vmHba->wwnn }}</td>
                                <td>{{ $vmHba->wwpn }}</td>
                                <td>{{ $vmHba->firmware }}</td>
                                <td>{{ $vmHba->driver_name }}</td>
                                <td>{{ $vmHba->driver_version }}</td>
                                <td>{{ $vmHba->info }}</td>
                                <td>{{ $vmHba->vid }}</td>
                                <td>{{ $vmHba->did }}</td>
                                <td>{{ $vmHba->svid }}</td>
                                <td>{{ $vmHba->ssid }}</td>
                                <td style="text-align:center; ">
                                    <a href="https://www.vmware.com/resources/compatibility/search.php?deviceCategory=io&details=1&VID={{ $vmHba->vid }}&DID={{ $vmHba->did }}&SVID={{ $vmHba->svid }}&SSID={{ $vmHba->ssid }}&page=1&display_interval=10&sortColumn=Partner&sortOrder=Asc"
                                    target="_blank" title="Consultar Compatibilidad">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-eye" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>El Vm Host no registra HBA's aun</p>
                @endif
            </div>
        </div>
        <div class="card with-border">
            <div class="card-header">
                <h3 class="card-title">NIC's registradas para el Vm Host</h3>
            </div>
            <div class="card-body">
                @if($vmHost->vmNics->count() > 0)
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>VM NIC</th>
                            <th>Bus Info</th>
                            <th>Driver</th>
                            <th>Firmware</th>
                            <th>Version</th>
                            <th>VID</th>
                            <th>DID</th>
                            <th>SVID</th>
                            <th>SSID</th>
                            <th title="Consultar Compatibilidad">CC</th>
                        </tr>
                        @foreach($vmHost->vmNics as $vmNic)
                            <tr>
                                <td>{{ $vmNic->vmnic }}</td>
                                <td>{{ $vmNic->bus_info }}</td>
                                <td>{{ $vmNic->driver }}</td>
                                <td>{{ $vmNic->firmware }}</td>
                                <td>{{ $vmNic->version }}</td>
                                <td>{{ $vmNic->vid }}</td>
                                <td>{{ $vmNic->did }}</td>
                                <td>{{ $vmNic->svid }}</td>
                                <td>{{ $vmNic->ssid }}</td>
                                <td style="text-align:center; ">
                                    <a href="https://www.vmware.com/resources/compatibility/search.php?deviceCategory=io&details=1&VID={{ $vmNic->vid }}&DID={{ $vmNic->did }}&SVID={{ $vmNic->svid }}&SSID={{ $vmNic->ssid }}&page=1&display_interval=10&sortColumn=Partner&sortOrder=Asc"
                                    target="_blank" title="Consultar Compatibilidad">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-eye" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>El Vm Host no registra NIC's aun</p>
                @endif
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
