@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de asignación de permisos</h1><hr>
@stop
@section('plugins.Select2', true)
@section('content')
    @can('permission-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('permissions.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('permissions.assignStore') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de asignación de permisos</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="permissions" class="control-label">Permisos:</label>
                        <div class="input-group">
                            <select name="permissions[]" id="permissions" class="form-control" multiple="multiple" style="width: 100%" required>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="permisos" class="control-label">Roles:</label>
                        @foreach ($roles as $rol)
                            <div class="col-sm-10">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="permisos{{ $rol->id }}" name="roles[]" value="{{ $rol->name }}" >
                                    <label for="permisos{{ $rol->id }}" class="custom-control-label">{{ $rol->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
    <script>
        $(document).ready(function() {
            $('#permissions').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
        });
    </script>
@stop

