@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de tareas de desarrollo</h1><hr>
@stop
@section('content')
    @can('devTask-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('devTasks.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('devTasks.update',$devTask->id) }} " method="post">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de edición de tareas de desarrollo</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="name" class="text-md-right">Nombre de la tarea</label>
                            </th>
                            <td>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $devTask->name }}" placeholder="Nombre de la tarea" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" maxlength="100" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="min" class="text-md-right">Tiempo mínimo (Minutos)</label>
                            </th>
                            <td>
                                <input type="number" name="min" id="min" class="form-control" value="{{ $devTask->min_time }}" placeholder="Tiempo en minutos" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="max" class="text-md-right">Tiempo máximo (Minutos)</label>
                            </th>
                            <td>
                                <input type="number" name="max" id="max" class="form-control" value="{{ $devTask->max_time }}" placeholder="Tiempo en minutos" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="description" class="text-md-right">Descripción de la tarea</label>
                            </th>
                            <td>
                                <input type="text" name="description" id="description" class="form-control" value="{{ $devTask->description }}" placeholder="Descripción de la tarea (Opcional)" maxlength="150">
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

