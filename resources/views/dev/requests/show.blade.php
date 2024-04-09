@extends('adminlte::page')
@section('content_header')
    <h1> Requerimiento # {{ $devRequest->id }}</h1><hr>
@stop
@section('content')
    @can('devRequest-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('devRequests.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Tarea de desarrollo</label>
                    <p>{{ $devRequest->task->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <p>{{ $devRequest->state->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Solicitante</label>
                    <p>{{ $devRequest->customer->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Responsable</label>
                    <p>{{ $devRequest->owner->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de creación del requerimiento</label>
                    <p> {{ $devRequest->created_at }}</p>
                    <hr>
                </div>
                @if($devRequest->solved_at != NULL)
                    <div class="form-group">
                        <label>Fecha de cierre del requerimiento</label>
                        <p> {{ $devRequest->solved_at }}</p>
                        <hr>
                    </div>
                @endif
                <div class="form-group">
                    <label>ID de template</label>
                    <p> {{ $devRequest->template_id }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>ID de inventario</label>
                    <p> {{ $devRequest->inventory_id }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <p> {{ $devRequest->description }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Comentarios</label>
                    <p> {{ $devRequest->comment }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Titulo de la vista</label>
                    <p> {{ $devRequest->title }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Titulo en el menu</label>
                    <p> {{ $devRequest->title_menu }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>ID de ejecución exitosa</label>
                    <p> {{ $devRequest->success_id }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>ID de ejecución fallida</label>
                    <p> {{ $devRequest->error_id }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Usuario acepto los terminos</label>
                    <p>@if($devRequest->read_terms == true) Si @else No @endif</p>
                    <hr>
                </div>
            </div>
        </div>
        <div class="card with-border">
            <div class="card-header">
                <h3 class="card-title">Campos del requerimiento</h3>
            </div>
            <div class="card-body">
                @if($devRequest->fields->count() > 0)
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Titulo</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Comentario</th>
                            <th>Requerido</th>
                            <th>Variable</th>
                        </tr>
                        @foreach($devRequest->fields as $field)
                            <tr>
                                <td>{{ $field->title }}</td>
                                <td>{{ $field->field_type }}</td>
                                <td>{{ $field->name }}</td>
                                <td>{{ $field->comment }}</td>
                                <td>@if($field->required == true) Si @else No @endif</td>
                                <td>@if($field->variable == true) Si @else No @endif</td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>El requerimiento no tiene campos asignados</p>
                @endif
            </div>
        </div>
        <div class="card with-border">
            <div class="card-header">
                <h3 class="card-title">Historial del requerimiento</h3>
            </div>
            <div class="card-body">
                @if($devRequest->histories->count() > 0)
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Estado</th>
                            <th>Responsable</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                        </tr>
                        @foreach($devRequest->histories as $history)
                            <tr>
                                <td>{{ $history->state->name }}</td>
                                <td>{{ $history->user->name }}</td>
                                <td>{{ $history->comment }}</td>
                                <td>{{ $history->created_at }}</td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>El requerimiento no tiene campos asignados</p>
                @endif
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
