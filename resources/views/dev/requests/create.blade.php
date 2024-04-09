@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de requerimientos de desarrollo</h1><hr>
@stop
@section('content')
    @can('devRequest-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#terms">
                        <i class="fa fa-book"></i> Terminos y condiciones
                    </a>
                    <a class="btn btn-sm btn-danger" href="{{ route('devRequests.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{route('devRequests.store') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="improvement" id="improvement" value="{{ $regImprovement }}">
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de requerimientos de desarrollo</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="task" class="text-md-right">Tarea a desarrollar</label>
                            </th>
                            <td>
                                <select name="task" id="task" class="form-control" required>
                                    @foreach($tasks as $task)
                                        <option value="{{ $task->id }}">{{ $task->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="template" class="text-md-right">ID del template (en AWX)</label>
                            </th>
                            <td>
                                <input type="number" min="0" max="32767" name="template" id="template" class="form-control" value="{{ old('template') }}" placeholder="ID del template" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="inventory" class="text-md-right">ID del inventario</label>
                            </th>
                            <td>
                                <input type="number" min="0" max="32767" name="inventory" id="inventory" class="form-control" value="{{ old('inventory') }}" placeholder="0">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="title" class="text-md-right">Título de la vista</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Título de la vista" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,100}" maxlength="100" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                            title="Ayuda" data-content="Hace referencia al título en la parte superior izquierda, normalmente va acompañado de la palabra 'Formulario de..'"><i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="menu" class="text-md-right">Título en el menu</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="menu" id="menu" class="form-control" value="{{ old('menu') }}" placeholder="Título en el menu" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,30}" maxlength="30" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                title="Ayuda" data-content="Título que sera visualizado en el menu de Asgard"><i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="description" class="text-md-right">Descripción  de la vista</label>
                            </th>
                            <td>
                                <textarea name="description" id="description" class="form-control" placeholder="Descripción de la vista (Opcional)"
                                          maxlength="200" rows="2">{{ old('description') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="success" class="text-md-right">ID de ejecución exitosa</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="number" name="success" id="success" min="1" max="4" class="form-control" value="{{ old('success') }}" placeholder="0">
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                              title="Opciones permitidas" data-content="<ul><li>1 = OK resultado sera un link local Asgard</li>
                                                    <li>2 = OK resultado sera = campo resultado de la tabla</li>
                                                    <li>3 = OK resultado consumirá el stdout de la API</li>
                                                    <li>4 = OK resultado sera un link externo</li></ul>"><i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="bad" class="text-md-right">ID de ejecución fallida</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="number" name="bad" id="bad" class="form-control" min="12" max="13" value="{{ old('bad') }}" placeholder="0">
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                              title="Opciones permitidas" data-content="<ul><li>12 = ERROR resultado sera = campo resultado de la tabla</li>
                                                    <li>13 = ERROR resultado consumirá el stdout de la API</li></ul>"><i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="bad" class="text-md-right">He leido los <a href="#" data-toggle="modal" data-target="#terms">
                                        terminos y condiciones</a> para la ejecución de playbooks</label>
                            </th>
                            <td>
                                <input type="checkbox" name="term" id="term"  value="1" required>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <p>
                        Una vez guarde el requerimiento será direccionado al modulo de detalles de la vista, en este modulo continuara el proceso de generación
                        de su requerimiento.
                    </p>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
        <div class="modal fade" id="terms" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Condiciones para la ejecución de playbooks desde Asgard</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Recuerde que para lograr que los playbooks se ejecuten correctamente desde Asgard es necesario que se cumplan ciertas condiciones las cuales citamos a continuación:</p>
                        <ul>
                            <li>Los Playbook deben tener permisos de ejecución para el usuario apiasgard</li>
                            <li>Los Playbook no deben tener configurado un límite (esto aplica si el playbook solicita un listado de host)</li>
                            <li>Los Playbook deben tener activo el check de "preguntar al ejecutar" para la casilla variables adicionales
                                (esto aplica si el playbook solicita cualquier variable)</li>
                            <li>Los Playbooks no deben tener en sus encuestas validaciones que impidan que las variables sean enviadas por el api,
                                en caso de no poder eliminar dichos campos se debe desactivar la encuesta</li>
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection


