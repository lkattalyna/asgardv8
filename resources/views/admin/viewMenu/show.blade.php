@extends('adminlte::page')
@section('content_header')
    <h1> Consultar Menus</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('menu-create')
        <div class="card card-default">
            <div class="card-body">
                <a href="{{ route('admin.menus.index')}}" class="btn btn-sm btn-secondary">
                    <span class="fas fa-bars fa-1x"></span>&nbsp Volver a menu nivel 1
                </a>
                @if ( ($menuPadre->id_menu_father != 0) )
                <a href="{{ route('admin.menus.show' , ["menu" => $menuPadre->id_menu_father])}}" class="btn btn-sm btn-danger">
                    <span class="fa fa-arrow-left  fa-1x"></span>&nbsp Volver a menu anterior
                </a>
                @endif
                <a href="{{ route('admin.menus.create', ['menu' => $menuPadre->id]) }}" class="btn btn-sm btn-info">
                    <span class="fas fa-plus fa-1x"></span>&nbsp Agregar Menu a {{ $menuPadre->text }}
                </a>
                <a href="{{ route('admin.menus.createWithAuto', ['menu' => $menuPadre->id]) }}" class="btn btn-sm btn-warning text-white">
                    <span class="fas fa-plus fa-1x"></span>&nbsp Agregar Menu(Automatización) a {{ $menuPadre->text }}
                </a>

                <form action="{{route('admin.menus.createWithSubMenusPOST', ['idPadre' => $menuPadre->id ])}}" method="post" class="d-none mt-3" id="formEmbeber">
                    {!! csrf_field() !!}
                    <div class="d-none" id="displayCheckBox">

                    </div>
                    <button type="submit" class="btn btn-sm btn-primary"> <span class="fas fa-plus fa-1x"></span>&nbsp Embeber Menu</button>
                </form>

                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Menús de {{ $menuPadre->text }} registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                @if( COUNT($menus) > 0)

                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                    <tr>
                        <th></th>
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
                            <td class="text-center"><input value="{{$menu->id}}" onchange="adicionarMenuEmbebido(this,'{{$menu->text}}')" type="checkbox" /> </td>
                            <td class="text-center"><i class="{{ $menu->icon }}">  </i> </td>
                            <td>{{ $menu->text }}</td>
                            <td>{{ $menu->is_title }}</td>
                            <td>{{ ( isset($menu->can) ? $menu->can->name:'NO IDENTIFICADO ACTUALIZAR' )  }}</td>
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

                @else
                    @include('admin.viewMenu.formEspecializar')
                @endif
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

@section('js')
    @if(COUNT($menus) > 0)
        @include('admin.viewMenu.scriptsShow')
    @endif
    @include('layouts.tableFull')
@endsection
