@extends('adminlte::page')
@section('content_header')
<h1> Consultar switches registrados</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('content')
    @can('sanSwitch-list')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Switches registradas en el sistema</h3>
                <div class="float-sm-right"><h6>Última actualización: {{ $log }}</h6></div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre Switch</th>
                            <th>Fabric</th>
                            <th>IP</th>
                            <th>Dominio</th>
                            <th>Serial</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->sw }}</td>
                                <td>{{ $item->fabric }}</td>
                                <td>{{ $item->ip }}</td>
                                <td>{{ $item->domain }}</td>
                                <td>{{ $item->serial }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        <a href="{{ route('sanSwitch.show',$item->id)}}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                        @can('sanSwitch-edit')
                                            <a href="{{ route('sanSwitch.edit',$item->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('sanSwitch-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('sanSwitch.destroy',$item->id)}}" data-toggle="modal" data-target="#confirm-delete">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-trash" style="color: #c51f1a;"></i>
                                                </button>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

@section('js')
    @include('layouts.tableFull')
@endsection
