@extends('adminlte::page')
@section('content_header')
    <h1> Consultar estados de desarrollo</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('devState-list')
        <div class="card card-default">
            <div class="card-body">
                @can('devState-create')
                    <a href="{{ route('devStates.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Estado de Desarrollo
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Estados registradas en el sistema</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre del estado</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($states as $state)
                            <tr>
                                <td>{{ $state->name }}</td>
                                <td>{{ $state->description }}</td>
                                <td class="center">
                                    @can('devState-edit')
                                        <a href="{{route('devStates.edit',$state->id)}}" title="Editar">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-edit" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('devState-delete')
                                        <a href="#" title="Eliminar" data-href="{{route('devStates.destroy',$state->id)}}"
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
