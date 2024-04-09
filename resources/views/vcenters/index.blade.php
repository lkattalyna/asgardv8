@extends('adminlte::page')
@section('content_header')
    <h1> Consultar vcenter creados</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('devState-list')
        <div class="card card-default">
            <div class="card-body">
                @can('devState-create')
                    <a href="{{ route('vcenters.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Vcenter
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Vcenter registrados en el sistema</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Id Vcenter</th>
                            <th>Segmento</th>
                            <th>login</th>
                            <th>Ip Vcenter</th>
                            <th>Alias Vcenter</th>
                            <th>Estado Vcenter</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vcenters as $vcenter)
                            <tr>
                                <td>{{ $vcenter->vcenterID }}</td>
                                <td>
                                    @if ($vcenter->fk_segmentID == '1')
                                            <label class="badge badge-secondary">Empresas Y Negocios</label>
                                        @elseif ($vcenter->fk_segmentID == '2')
                                            <label class="badge badge-primary">Personas Y Hogares</label>
                                        @elseif ($vcenter->fk_segmentID == '3')
                                            <label class="badge badge-warning">Convergencia</label>
                                    @endif
                                </td>
                                <td>
                                    @if ($vcenter->fk_loginAccountID == '1' || $vcenter->fk_loginAccountID == '5')
                                        <label class="badge badge-warning">datacenterdhs\asgard.cli</label>
                                    @elseif ($vcenter->fk_loginAccountID == '2')
                                        <label class="badge badge-danger">dfgftcla1</label>
                                    @elseif ($vcenter->fk_loginAccountID == '3')
                                        <label class="badge badge-success">ctxadmin</label>
                                    @elseif ($vcenter->fk_loginAccountID == '4')
                                        <label class="badge badge-secondary">root</label>
                                    @elseif ($vcenter->fk_loginAccountID == '6' || $vcenter->fk_loginAccountID == '7')
                                        <label class="badge badge-info">asgard.cli@vsphere.local</label>
                                    @elseif ($vcenter->fk_loginAccountID == '8')
                                        <label class="badge badge-primary">cloudclaro\asgard.cli</label>
                                    @elseif ($vcenter->fk_loginAccountID == '9')
                                        <label class="badge badge-dark">COLCLOUD\vmwarepowercli</label>
                                   
                                @endif
                                </td>
                                <td>{{ $vcenter->vcenterIp }}</td>
                                <td>{{ $vcenter->vcenterAlias }}</td>
                                <td>
                                    @if($vcenter->vcenterStatus == true)
                                        <label class="badge badge-success">Encendido</label>
                                    @else
                                        <label class="badge badge-danger">Apagado</label>
                                    @endif
                                </td>

                                <td class="center">
                                    @can('devState-edit')
                                        <a href="{{route('vcenters.edit',$vcenter->vcenterID)}}" title="Editar">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-edit" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('devState-delete')
                                        <a href="#" title="Eliminar" data-href="{{route('vcenters.destroy',$vcenter->vcenterID)}}"
                                            data-toggle="modal" data-target="#confirm-delete">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-trash" style="color: #c51f1a;"></i>
                                            </button>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
