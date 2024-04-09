@extends('adminlte::page')
@section('content_header')
<h1> Consultar links registrados</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('sanLink-list')
        <div class="card card-default">
            <div class="card-body">
                @can('sanLink-create')
                    <a href="{{ route('sanLink.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo link
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Links registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Link</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->link }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        <a href="{{ $item->link }}" target="_blank" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                        @can('sanLink-edit')
                                            <a href="{{ route('sanLink.edit',$item->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('sanLink-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('sanLink.destroy',$item->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
