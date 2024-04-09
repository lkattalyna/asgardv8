@extends('adminlte::page')
@section('content_header')
    <h1> Consultar Menus</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('menu-create')
        <div class="card card-default">
            <div class="card-body">
                    <a href="{{ route('admin.menus.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevos Menus
                    </a>
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Menús de primer nivel registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                    <tr>
                        <th>Icono</th>
                        <th>Nombre Menu</th>
                        <th>Titulo</th>
                        <th>Permiso</th>
                        <th>Url</th>
                        <th>Orden</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ( $menus as $menu )
                        <tr>
                            <td class="text-center"><i class="{{ ($menu->is_title == 'SI') ? 'fas fa-arrows-alt-h':$menu->icon }}">  </i> </td>
                            <td>{{ $menu->text }}</td>
                            <td>{{ $menu->is_title }}</td>
                            <td>{{ $menu->can->name }}</td>
                            <td>{{ $menu->url }}</td>
                            <td>{{ $menu->order }}</td>
                            <td>
                                <a href="{{ route('admin.menus.show' , [ "menu" => $menu->id ]) }}"  title="Ver Submenu">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                                <a href="{{ route('admin.menus.edit' , [ "menu" => $menu->id ]) }}"  title="Editar menu">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fas fa-edit" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                                @if( $menu->is_title != 'SI')
                                <a href="{{ route('admin.menus.create' , [ "menu" => $menu->id ]) }}"  title="Agregar menu hijo">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fas fa-plus" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                                @endif
                                <a href="#" title="Eliminar" data-href="{{ route('admin.menus.destroy' , [ 'menu' => $menu->id ]) }}" data-toggle="modal" data-target="#confirm-delete">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-trash" style="color: #c51f1a;"></i>
                                    </button>
                                </a>                                
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
