@extends('adminlte::page')
@section('content_header')
    <h1> Edición de Menús</h1><hr>
@stop
@section('content')
    @can('menu-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ ($menuEdit->id_father_menu == 0) ? route('admin.menus.index') : route('admin.menus.show', ['menu' =>
                $menuEdit->id]) }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{route('admin.menus.update',['menu'=>$menuEdit->id]) }}" method="post">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de edición de menús</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="name" class="text-md-right">Menu padre</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-bars"></i></span>
                                    </div>
                                    <select class="form-control" name="id_menu_father" id="id_menu_father" required>
                                        @if ( $menuEdit->id_menu_father == 0)
                                            <option selected value="0">NINGUNO</option>
                                        @else
                                            <option value="0">NINGUNO</option>
                                            <option value="{{ $menuEdit->id_menu_father  }}" selected>{{ $menuEdit->relBelongSubmenu->text }}</option>
                                        @endif
                                        @foreach($menus as $menu)
                                            <option {{ ($menuEdit->id_menu_father == $menu['id'])?'selected':'' }} value="{{ $menu['id'] }}">{{ $menu['text'] }}</option>
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
                                            <option {{ ($menuEdit->id_permission == $permission['id'])?'selected':'' }} value="{{ $permission['id'] }}">{{ $permission['name'] }}</option>
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
                                    <input value="{{ ($menuEdit->text) }}" type="text" name="text" id="text" class="form-control" placeholder="Texto" required>
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
                                    <input value="{{ ($menuEdit->icon) }}" type="text" name="icon" id="icon" class="form-control" placeholder="Icono">
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
                                    <input value="{{ ($menuEdit->order) }}" type="number" step="0.01" min="1" max="100" name="order" id="order" class="form-control" placeholder="Orden" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="is_title" class="text-md-right">Título</label>
                            </th>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input {{ ($menuEdit->is_title == 'SI')?'checked':'' }} class="custom-control-input" type="checkbox" id="is_title" name="is_title" value="1" defaultValue="0">
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
                                    <input value="{{ ($menuEdit->url) }}" type="text" name="url" id="url" class="form-control" placeholder="URL"  required>
                                </div>
                            </td>
                        </tr>
                        <tr class="d-none">
                            <th>
                                <label for="level" class="text-md-right">Nivel</label>
                            </th>
                            <td >
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-cog"></i></span>
                                    </div>
                                    <select class="form-control" name="level" id="level" required>
                                            <option {{ ($menuEdit->level == 1)?'selected':'' }} value=1>Primer nivel</option>
                                            <option {{ ($menuEdit->level == 2)?'selected':'' }} value=2>Subnivel</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
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
