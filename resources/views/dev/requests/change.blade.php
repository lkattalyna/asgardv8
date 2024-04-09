@extends('adminlte::page')
@section('content_header')
    <h1> Formulario cambio de estado de requerimiento</h1><hr>
@stop
@section('content')
    @can('devRequest-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('devRequests.indexAdmin')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{route('devRequests.changeStore', $devRequest->id) }}" method="post">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario cambio de estado de requerimiento</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="task" class="text-md-right">Requerimiento</label>
                            </th>
                            <td>{{ $devRequest->id }}</td>
                        </tr>
                        <tr>
                            <th>
                                <label for="task" class="text-md-right">Estado actual</label>
                            </th>
                            <td>{{ $devRequest->state->name }}</td>
                        </tr>
                        <tr>
                            <th>
                                <label for="state" class="text-md-right">Nuevo estado</label>
                            </th>
                            <td>
                                <select name="state" id="state" class="form-control" required>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="comment" class="text-md-right">Comentario</label>
                            </th>
                            <td>
                                <textarea name="comment" id="comment" class="form-control" placeholder="Comentario (Opcional)"
                                          maxlength="150" rows="2">{{ old('comment') }}</textarea>
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


