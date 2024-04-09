@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Resultado de la búsqueda</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-header">
            <div class="card-tools pull-right">
                <a class="btn btn-sm btn-danger" href="{{ route('updatePacks.search') }}">
                    <span class="fa fa-sync fa-1x"></span>&nbsp Actualizar servidores
                </a>
            </div>
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>
    @if (isset($error))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p><i class="icon fa fa-info"></i> {{ $error }}</p>
        </div><br/>
    @endif
    @if ($hasUpdatePack != 0)
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Servidores encontrados en la búsqueda</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Código de servicio</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Bios</th>
                    <th>ILO</th>
                    <th>Controladora</th>
                    <th>PM</th>
                    <th>NIC</th>
                    <th>HBA</th>
                    <!--<th>OA</th>
                    <th>VC_Lan</th>
                    <th>VC_San</th>-->
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pendientes as $pendiente)
                    <tr>
                        <td>{{ $pendiente->cod_servicio }}</td>
                        <td>{{ $pendiente->marca }}</td>
                        <td>{{ $pendiente->modelo }}  </td>
                        <td>
                            @if($pendiente->bios==0)
                                <label class="badge badge-danger">ERR</label>
                            @else
                                <label class="badge badge-success">OK</label>
                            @endif
                        </td>
                        <td>
                            @if($pendiente->ilo==0)
                                <label class="badge badge-danger">ERR</label>
                            @else
                                <label class="badge badge-success">OK</label>
                            @endif
                        </td>
                        <td>
                            @if($pendiente->controladora==0)
                                <label class="badge badge-danger">ERR</label>
                            @else
                                <label class="badge badge-success">OK</label>
                            @endif
                        </td>
                        <td>
                            @if($pendiente->power_management==0)
                                <label class="badge badge-danger">ERR</label>
                            @else
                                <label class="badge badge-success">OK</label>
                            @endif
                        </td>
                        <td>
                            @if($pendiente->nic==0)
                                <label class="badge badge-danger">ERR</label>
                            @else
                                <label class="badge badge-success">OK</label>
                            @endif
                        </td>
                        <td>
                            @if($pendiente->hba==0)
                                <label class="badge badge-danger">ERR</label>
                            @else
                                <label class="badge badge-success">OK</label>
                            @endif
                        </td>
                        <!--
                        <td>
                            @if($pendiente->oa==0)
                                <label class="label label-danger">ERR</label>
                            @else
                                <label class="label label-success">OK</label>
                            @endif
                        </td>
                        <td>
                            @if($pendiente->vc_lan==0)
                                <label class="label label-danger">ERR</label>
                            @else
                                <label class="label label-success">OK</label>
                            @endif
                        </td>
                        <td>
                            @if($pendiente->vc_san==0)
                                <label class="label label-danger">ERR</label>
                            @else
                                <label class="label label-success">OK</label>
                            @endif
                        </td>
                    -->
                        <td class="center">
                            <a href="{{ route('updateLogs.create',$pendiente->id)}}" target="_blank" title="Actualizar">
                                <button class="btn btn-sm btn-default">
                                    <i class="fa fa-sync" style="color: #0d6aad"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.card-body -->
        <div class="overlay" id="cargando"><!-- Animación Cargando -->
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div><!-- /.card -->
    @endif

    @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
