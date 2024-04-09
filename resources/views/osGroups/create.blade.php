@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de grupos de usuarios</h1><hr>
@stop
@section('content')
    @can('OsGroup-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('osGroups.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('osGroups.store') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de grupos de usuarios</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre del grupo:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,120}" required  value="{{ old('name') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="flag" class="col-sm-2 control-label">Inventario asociado:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="flag" name="flag" type="number" pattern="^[0-9]" required  value="{{ old('flag') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="show" class="col-sm-2 control-label">Mostar a:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="show" name="show" type="text" placeholder="all"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,20}" required  value="{{ old('show') }}"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
