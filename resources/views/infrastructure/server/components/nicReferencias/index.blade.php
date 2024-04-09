@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Referencias de NIC</h1>
    <hr>
@stop
@section('content')
@section('plugins.Datatables', true)
    <div class="card card-default">
        <div class="card-header">
            @can('recursos-run')
                <div class="card-tools pull-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('nicReferencias.create') }}">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Crear Nueva Referencia de NIC
                    </a>
                </div>
            @endcan
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>

    @include('layouts.messages')
    <div class="card">
        <div class="card-header with-border">
            <h3 class="card-title">Referencias de NIC registradas en el sistema</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Referencia</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tipos as $tipo)
                    <tr>
                        <td>{{ $tipo->id }}</td>
                        <td>{{ $tipo->nombre }}</td>
                        <td class="center">
                            <div class="btn-group">
                                @can('recursos-run')
                                    <a href="{{ route('nicReferencias.edit',$tipo->id)}}" title="Editar">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-edit" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                @endcan
                                @can('recursos-run')
                                    <a href="#" title="Eliminar" data-href="{{route('nicReferencias.destroy',$tipo->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
@stop
@section('js')
    @include('layouts.tableFull')
@stop
