@extends('adminlte::page')
@section('content_header')
    <h1> Formulario asignación de requerimientos de desarrollo</h1><hr>
@stop
@section('content')
    @can('devRequest-admin')
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
        <form action="{{route('devRequests.assignStore', $devRequest->id) }}" method="post">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de asignación de requerimientos de desarrollo</h3>
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
                                <label for="task" class="text-md-right">Responsable:</label>
                            </th>
                            <td>
                                <select name="owner" id="owner" class="form-control" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
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


