@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de estados de desarrollo</h1><hr>
@stop
@section('content')
    @can('devState-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('devStates.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{route('devStates.store') }}" method="post">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de estados de desarrollo</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="name" class="text-md-right">Nombre del estado</label>
                            </th>
                            <td>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nombre de la tarea" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" maxlength="100" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="description" class="text-md-right">Descripción  del estado</label>
                            </th>
                            <td>
                                <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" placeholder="Descripción de la tarea (Opcional)" maxlength="150">
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

