@extends('adminlte::page')

@section('content_header')
<h1>Formulario de Registro de Iniciativas Automatizaciones</h1>
<hr>
@stop

@section('plugins.Select2', true)
@section('plugins.Date-Picker', true)

@section('content')
<div class="card card-default">
    <div class="card-body">
        <div class="float-sm-right">
            <a class="btn btn-sm btn-danger" href="{{ route('initiative.index') }}">
                <i class="fa fa-reply"></i> Volver
            </a>
        </div>
    </div>
</div>
@include('layouts.formError')

<form action="" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="card card-default">
        <div class="card-header with-border">
            <p>Este formulario permitirá consignar y almacenar las solicitudes de Iniciativas de automatizaciones y sus
                criterios de aceptación.</p>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">

                <!--nombre iniciativa-->
                <tr>
                    <th>
                        <label for="initiativeName" class="text-center">Nombre de la Iniciativa</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="initiativeName" id="initiativeName" class="form-control" placeholder="Nombre de la Iniciativa" maxlength="200" rows="2" required>{{ old('initiativeName') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Indique el nombre que desea asignar a la iniciativa">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- Resto de los campos -->

                <!--Segmento-->
                <tr>
                    <th>
                        <label for="segment" class="text-center" placeholder="Yo como...">Segmento</label>
                    </th>
                    <td>
                        <select class="form-control" name="segment" id="segment" style="width: 100%;" required>
                            <!--Revisar BD??-->
                            <option></option>

                            @if (isset($segments))
                            @foreach ($segments as $segment)
                            <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </td>
                </tr>

                <!--capa de servicios / "torre"-->
                <tr>
                    <th>
                        <label for="service_layer" class="text-center">Torre de Servicio</label>
                    </th>
                    <td>
                        <select class="form-control" name="service_layer" id="service_layer" style="width: 100%;" required>
                            <option></option>

                            @if (isset($service_layers))
                            @foreach ($service_layers as $service_layer)
                            <option value="{{ $service_layer->id }}">{{ $service_layer->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </td>
                </tr>

                <!--como-->
                <tr>
                    <th>
                        <label for="how" class="text-md-right">Como</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="how" id="how" class="form-control" placeholder="Yo como..." maxlength="200" rows="2" required>{{ old('how') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Describa el perfil de quien usará la Funcionalidad / Automatización a desarrollar, Ejemplo: Usuario administrador de Asgard">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Quiero-->
                <tr>
                    <th>
                        <label for="want" class="text-md-right">Quiero</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="want" id="want" class="form-control" placeholder="Quiero automatizar..." maxlength="200" rows="" required>{{ old('want') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Describa el objetivo o lo que se desea de la funcionalidad / Automatización a desarrollar">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Quiero-->
                <tr>
                    <th>
                        <label for="for" class="text-md-right">Para</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="for" id="for" class="form-control" placeholder="Para conseguir..." maxlength="200" rows="2" required>{{ old('for') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Describa cual será el resultado final de la funcionalidad / Automatización">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Tipo de automatizacion-->
                <tr>
                    <th>
                        <label for="automation_type" class="text-md-right">Tipo de automatización</label>
                    </th>
                    <td>
                        <select class="form-control" name="automation_type" id="automation_type" style="width: 100%;" required>
                            <option></option>
                            <option value="Acción">Acción</option>
                            <option value="Consulta">Consulta</option>
                        </select>
                    </td>
                </tr>

                <!--Tipo de tarea-->
                <tr>
                    <th>
                        <label for="task_type" class="text-md-right">Tipo de tarea</label>
                    </th>
                    <td>
                        <select class="form-control" name="task_type" id="task_type" style="width: 100%;" required>
                            <option></option>
                            <option value="Administrativa">Administrativa</option>
                            <option value="Implementación">Implementación</option>
                            <option value="Operativa">Operativa</option>
                        </select>
                    </td>
                </tr>

                <!--Descripcion General-->
                <tr>
                    <th>
                        <label for="general_description" class="text-md-right">Descripcion General</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="general_description" id="general_description" class="form-control" placeholder="Descripcion General" maxlength="200" rows="2" required>{{ old('general_description') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Describa detalladamente como visualiza la automatización">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Criterios de aceptación-->
                <tr>
                    <th>
                        <label for="acceptance_criteria" class="text-md-right">Criterios de Aceptación</label>
                    </th>
                    <td>
                        <div id="criterios-container">
                            <div class="input-group">
                                <textarea name="acceptance_criteria[][]" class="form-control" placeholder="Criterio de Aceptación 1" rows="2"></textarea>
                                <div class="input-group-append">
                                    <button type="button" id="agregar-criterio" class="btn btn-sm btn-danger">+</button>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" data-toggle="popover" data-html="true" title="Ayuda" data-content="Ingrese los criterios de automatizacion, tenga en cuenta que debe ingresar mínimo 1 criterios de aceptación y máximo 5">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


                <!--Archivos adjuntos-->
                <tr>
                    <th>
                        <label for="attachments">Archivos Adjuntos</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="attachments" name="attachments" accept=".pdf" onchange="updateFileName()">
                                <label class="custom-file-label" for="attachments">{{ __('Seleccione el archivo') }}</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true" title="Ayuda" data-content="Adjunte material de apoyo o documento indispensable para la funcionalidad / Automatización de ser requerido">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                        @if (isset($datosInitiative->attachments))
                        <p id="file-name">{{ $datosInitiative->attachments }}</p>
                        @endif
                    </td>
                </tr>

                <script>
                    function updateFileName() {
                        const input = document.getElementById('attachments');
                        const label = input.nextElementSibling;
                        const fileName = input.files[0].name;
                        label.innerText = fileName;
                        document.getElementById('file-name').innerText = fileName;
                    }
                </script>

                <!--Tiempo estimado del proceso manual-->
                <tr>
                    <th>
                        <label for="execution_time_manual" class="text-md-right">Cuanto tiempo le toma realizar este
                            proceso manualmente</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <input type="text" name="execution_time_manual" id="execution_time_manual" class="form-control timepicker" placeholder="Duración en Minutos" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text" data-toggle="popover" data-html="true" title="Ayuda" data-content="Aproxime el tiempo que le lleva realizar manualmente el proceso que desea Automatizar">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Ventajas de la Automatización-->
                <tr>
                    <th>
                        <label for="advantages" class="text-md-right">Que Ventajas traera esta automatización</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="advantages" id="advantages" class="form-control" placeholder="Ventajas de la Automatización" rows="4" required>{{ old('advantages') }}</textarea>
                            <div class="input-group-prepend">
                                <span class="input-group-text" data-toggle="popover" data-html="true" title="Ayuda" data-content="Comente las ventajas que obtendra la operación al realizar esta Automatización">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!--envio formulario-->
        <form action="{{ route('initiative.store') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <p>Este formulario permitirá consignar y almacenar las solicitudes de Iniciativas de
                        automatizaciones y sus criterios de aceptación.</p>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <!-- Aquí van los campos del formulario -->
                    </table>
                </div>
                <div class="card-footer">
                    <!--debe quedar guardada la fecha + hora de la solicitud. luego mensaje de confirmación-->
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </form>

        @stop

        @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Código para agregar criterios dinámicamente
                const criteriosContainer = document.getElementById('criterios-container');
                const agregarCriterioBtn = document.getElementById('agregar-criterio');

                let contadorCriterios = 1;
                const maxCriterios = 5;

                agregarCriterioBtn.addEventListener('click', function() {
                    if (contadorCriterios < maxCriterios) {
                        const nuevoCriterioDiv = document.createElement('div');
                        nuevoCriterioDiv.classList.add('input-group');

                        const nuevoCriterio = document.createElement('textarea');
                        nuevoCriterio.name = 'acceptance_criteria[][]';
                        nuevoCriterio.classList.add('form-control');
                        nuevoCriterio.placeholder = 'Criterio de Aceptación ' + (contadorCriterios + 1);
                        nuevoCriterio.rows = 2;

                        const eliminarCriterioBtn = document.createElement('button');
                        eliminarCriterioBtn.type = 'button';
                        eliminarCriterioBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'ml-2');
                        eliminarCriterioBtn.textContent = 'Eliminar';
                        eliminarCriterioBtn.addEventListener('click', function() {
                            criteriosContainer.removeChild(nuevoCriterioDiv);
                            contadorCriterios--;
                        });

                        nuevoCriterioDiv.appendChild(nuevoCriterio);
                        nuevoCriterioDiv.appendChild(eliminarCriterioBtn);
                        criteriosContainer.appendChild(nuevoCriterioDiv);
                        contadorCriterios++;
                    } else {
                        alert('No se pueden agregar más criterios.');
                    }
                });

                // Verificar campos vacíos antes de guardar
                document.getElementById('guardar-btn').addEventListener('click', function() {
                    const criterios = document.querySelectorAll('textarea[name="acceptanceCriteria[]"]');
                    let campoVacio = false;
                    criterios.forEach(function(criterio) {
                        if (criterio.value.trim() === '') {
                            campoVacio = true;
                        }
                    });
                    if (campoVacio) {
                        alert('Por favor, complete todos los criterios antes de guardar.');
                    } else {
                        alert('Todos los criterios han sido completados.');
                        // Aquí puedes agregar la lógica para guardar los criterios
                    }
                });
            });

            $(document).ready(function() {
                $('[data-toggle="popover"]').popover();

                // Configuración de select2 y otros elementos
                $('#layer').select2({
                    placeholder: "-- Seleccione --",
                    allowClear: true
                });
                $('#segment').select2({
                    placeholder: "-- Seleccione --",
                    allowClear: true
                });
                $('#quarter').select2({
                    placeholder: "-- Seleccione --",
                    allowClear: true
                });
                $('#tAut').select2({
                    placeholder: "-- Seleccione --",
                    allowClear: true
                });
                $('#task').select2({
                    placeholder: "-- Seleccione --",
                    allowClear: true
                });

            });
            $("#segment").change(function() {
            var segment = $(this).val()
            $.get('getLayers/' + segment, function(data) {
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                select = '';
                for (var i = 0; i < data.length; i++) {
                    select += '<option value="' + data[i].id + '">' + data[i].name +
                        '</option>';
                }
                $("#service_layer").html(select);
            });
            });
                    </script>
        @endsection