@extends('adminlte::page')
@section('content_header')
<h1> Consultar niveles de cliente</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('regCustomerLevel-list')
        <div class="card card-default">
            <div class="card-body">
                @can('regCustomerLevel-create')
                    <a href="{{ route('RegCustomerLevels.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Nivel de Cliente
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Niveles de cliente registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customerLevels as $customerLevel)
                            <tr>
                                <td>{{ $customerLevel->name }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        @can('regCustomerLevel-edit')
                                            <a href="{{ route('RegCustomerLevels.edit',$customerLevel->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('regCustomerLevel-delete')
                                            <a href="#" title="Eliminar" data-href="{{route('RegCustomerLevels.destroy',$customerLevel->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
