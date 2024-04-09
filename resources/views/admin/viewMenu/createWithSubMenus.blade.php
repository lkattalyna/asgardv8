@extends('adminlte::page')
@section('content_header')
    <h1> Creación de Menús</h1><hr>
@stop
@section('content')
    @can('menu-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('admin.menus.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')

                <div class="row">

                    <div class="col-md-6 mx-auto">
                        <div class="card card-default">
                            <div class="card-header">Ubicación Actual</div>
                            <div class="card-body">
                            @foreach( $menusSelected as $menucito)
                                <div class="input-group mt-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-bars"></i></span>
                                    </div>
                                    <select readonly class="form-control">
                                        @foreach($menus as $menu)
                                            <option  {{ $menu->id == $menucito ? 'selected':''}} value="{{ $menu['id'] }}">{{$menu->id}} - {{ $menu['text'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>


            </div>


            <div class="row">
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header">Estas embebiendo los siguientes menus</div>
                        <div class="card-body">
                            <ul>
                                @foreach ( $menusAdicionadosTitulos as $titulo )
                                    <li class="h5">{{$titulo}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">Formulario Asignación de menus</div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-12 ">
                                    <form action="{{route('admin.menus.createWithSubMenusPUT') }}" method="post">
                                        {!! csrf_field() !!}
                                        @method('PUT')
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <th>Menu padre</th>
                                                <td>
                                                    <select class="form-control select2">
                                                        @foreach($menus as $menu)
                                                            <option   value="{{ $menu['id'] }}">{{$menu->id}} - {{ $menu['text'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Menu Asignación</th>
                                                <td>
                                                    <select name="menuPadreReasignar" id="id_menu_father" class="form-control">
                                                        @foreach($menus as $menu)
                                                            <option value="{{ $menu['id'] }}">{{$menu->id}} - {{ $menu['text'] }}</option>
                                                        @endforeach
                                                    </select>

                                                </td>
                                            </tr>

                                            <input type="text" value="{{$menuAdicionados}}" name="menuAdicionados" hidden>
                                            <input type="text" value="reasignacion" name="subMenuTipo" hidden>
                                            <tr>
                                                <th></th>
                                                <td class="text-center">
                                                    <button class="d-block btn btn-primary text-center" type="submit">Reasignar Menu</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>







        <form action="{{route('admin.menus.createWithSubMenusPUT') }}" method="post">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de menús padre</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                            <label for="name" class="text-md-right">Menu padre</label>
                        </th>
                        <td>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-bars"></i></span>
                                </div>
                                <select class="form-control" name="id_menu_father" id="id_menu_father" required>
                                    @if ( isset($menuCreate) )
                                        <option value="0">NINGUNO</option>
                                    @else
                                        <option selected value="0">NINGUNO</option>
                                    @endif
                                    @foreach($menus as $menu)
                                        <option {{ $menu->id == $menuCreate ? 'selected':''}} value="{{ $menu['id'] }}">{{ $menu['id']}} - {{ $menu['text'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="email" class="text-md-right">Permiso</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-check-circle"></i></span>
                                </div>
                                <select class="form-control" name="id_permission" id="id_permission" required>
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission['id'] }}">{{ $permission['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="text" class="text-md-right">Texto</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-comment"></i></span>
                                </div>
                                <input type="text" name="text" id="text" class="form-control" placeholder="Texto" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="icon"
                                class="text-md-right">Icono</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                </div>
                                <input type="text" name="icon" id="icon" class="form-control" placeholder="Icono">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="password" class="text-md-right">Orden</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-clone"></i></span>
                                </div>
                                <input type="number" min="1" max="100" step="0.01" name="order" id="order" class="form-control" placeholder="Orden" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="is_title" class="text-md-right">Título</label>
                        </th>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_title" name="is_title" value="1" defaultValue="0">
                                <label for="is_title" class="custom-control-label"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="url" class="text-md-right">URL</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-globe"></i></span>
                                </div>
                                <input type="text" name="url" value="/" id="url" class="form-control" placeholder="URL"  required>
                            </div>
                        </td>
                    </tr>
                    <tr class="d-none">
                        <th>
                            <label for="level" class="text-md-right">Nivel</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-cog"></i></span>
                                </div>
                                <select class="form-control" name="level" id="level" required>
                                        <option value=1>Primer nivel</option>
                                        <option value=2>Subnivel</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <input type="text" value="{{$menuAdicionados}}" name="menuAdicionados" hidden>
                    <input type="text" value="conCreacion" name="subMenuTipo" hidden>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('admin.viewMenu.scripts')
@endsection
