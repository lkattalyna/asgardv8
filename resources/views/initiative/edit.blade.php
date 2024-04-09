@extends('adminlte::page')
@section('content_header')
<h1>Formulario de Edición de Iniciativas Automatizaciones</h1>
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

<form action="{{ route('initiative.update', $datosInitiative->id) }}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    @method('PUT')
    <div class="card card-default">
        <div class="card-header with-border">
            <p>Este formulario permitirá editar y almacenar las solicitudes de Iniciativas de automatizaciones y sus
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
                            <textarea name="initiativeName" id="initiativeName" class="form-control" placeholder="" maxlength="100" required>{{ $datosInitiative->initiative_name }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Indica el nombre que desea asignar a la iniciativa">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Resto de los campos -->
                <!-- Segmento -->
                <tr>
                    <th>
                        <label for="segment" class="text-center">Segmento</label>
                    </th>
                    <td>
                        <select class="form-control select2-init" name="segment" id="segment" style="width: 100%;" required>
                            <!-- Revisar BD -->
                            <option></option>
                            @foreach ($segments as $segment)
                            <option value="{{ $segment->id }}" @if ($datosInitiative->segment_id == $segment->id) selected @endif>
                                {{ $segment->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <!-- Capa de servicios / "torre" -->
                <tr>
                    <th>
                        <label for="service_layer" class="text-center">Torre de Servicio</label>
                    </th>
                    <td>
                        <select class="form-control" name="service_layer" id="service_layer" style="width: 100%;" required>
                            <option></option>
                            @foreach ($service_layers as $service_layer)
                            <option value="{{ $service_layer->id }}" @if ($datosInitiative->service_layer_id == $service_layer->id) selected @endif>
                                {{ $service_layer->name }}
                            </option>
                            @endforeach
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
                            <textarea name="how" id="how" class="form-control" placeholder="Yo como..." maxlength="200" rows="2" required>{{ $datosInitiative->how }}{{ old('how') }}</textarea>
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
                            <textarea name="want" id="want" class="form-control" placeholder="Quiero automatizar..." maxlength="200" rows="2" required>{{ $datosInitiative->want }}{{ old('want') }}</textarea>
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
                            <textarea name="for" id="for" class="form-control" placeholder="Para conseguir..." maxlength="200" rows="2" required>{{ $datosInitiative->for }}{{ old('for') }}</textarea>
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
                            <option value="Acción" @if ($datosInitiative->automation_type == 'Acción') selected @endif>Acción</option>
                            <option value="Consulta" @if ($datosInitiative->automation_type == 'Consulta') selected @endif>Consulta
                            </option>
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
                            <option value="Administrativa" @if ($datosInitiative->task_type == 'Administrativa') selected @endif>
                                Administrativa</option>
                            <option value="Implementación" @if ($datosInitiative->task_type == 'Implementación') selected @endif>
                                Implementación</option>
                            <option value="Operativa" @if ($datosInitiative->task_type == 'Operativa') selected @endif>Operativa
                            </option>
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
                            <textarea name="general_description" id="general_description" class="form-control" placeholder="Descripcion General" maxlength="200" rows="2" required>{{ $datosInitiative->general_description }}{{ old('general_description') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Describa detalladamente como visualiza la automatización">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Criterios de aceptación-->


                <!--Archivos adjuntos-->
                <tr>
                    <th>
                        <label for="acceptance_criteria" class="text-md-right">Criterios de Aceptación</label>
                    </th>
                    <td>
                        <div id="criterios-container">
                            @if (is_null($criterias) || empty($criterias) || count($criterias) === 0)
                            <div class="input-group">
                                <textarea name="acceptance_criteria[]" class="form-control" placeholder="Criterio de Aceptación 1" rows="2"></textarea>
                                <div class="input-group-append">
                                    <button type="button" id="agregar-criterio" class="btn btn-sm btn-danger">+</button>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" data-toggle="popover" data-html="true" title="Ayuda" data-content="Ingrese los criterios de automatizacion, tenga en cuenta que debe ingresar mínimo 1 criterios de aceptación y máximo 5">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                            </div>
                            @else
                            @foreach ($criterias as $criteria)
                            <div class="input-group">
                                <textarea id="{{ $criteria->id }}" name="acceptance_criteria[][{{ $criteria->id }}]" class="form-control" placeholder="Criterio de Aceptación 1" rows="2">{{ $criteria->criterio }}{{ old('criterio') }}</textarea>
                                <div class="input-group-append">
                                    <button type="button" id="agregar-criterio" class="btn btn-sm btn-danger">+</button>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" data-toggle="popover" data-html="true" title="Ayuda" data-content="Ingrese los criterios de automatizacion, tenga en cuenta que debe ingresar mínimo 1 criterios de aceptación y máximo 5">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </td>
                </tr>




                <!--Tiempo estimado del proceso manual-->
                <tr>
                    <th>
                        <label for="execution_time_manual" class="text-md-left">Cuanto tiempo le toma realizar este
                            proceso manualmente</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <input type="text" name="execution_time_manual" id="execution_time_manual" class="form-control timepicker" placeholder="Duración en Minutos" required value="{{ $datosInitiative->execution_time_manual }}{{ old('execution_time_manual') }}">
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
                            <textarea name="advantages" id="advantages" class="form-control" placeholder="Ventajas de la Automatización" rows="4" required>{{ $datosInitiative->advantages }}{{ old('advantages') }}</textarea>
                            <div class="input-group-prepend">
                                <span class="input-group-text" data-toggle="popover" data-html="true" title="Ayuda" data-content="Comente las ventajas que obtendra la operación al realizar esta Automatización">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

        </div>

        <!-- USUARIO ADMINISTRADOR(1) / PERMISOS PARA CAMBIO DE ESTADO -->
        @if ($datosInitiative->owner_id === 1)
        <tr>
            <th>
                <label for="state" class="text-center">Estado</label>
            </th>
            <td>
                <select class="form-control" name="state" id="state" style="width: 100%;" required>
                    <option></option>
                    <option value="Registrado" @if ($datosInitiative->state == 'Registrado') selected @endif>Registrado
                    </option>
                    <option value="QA" @if ($datosInitiative->state == 'QA') selected @endif>QA</option>
                    <option value="UAT" @if ($datosInitiative->state == 'UAT') selected @endif>UAT</option>
                </select>
            </td>
        </tr>
        @endif
        </table>
        <div class="card-footer">
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fa fa-save"></i> Guardar
            </button>
        </div>
    </div>
    @stop

    @section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Código para agregar criterios dinámicamente
        });

        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
            // Configuración de select2 y otros elementos
            $("#segment").change(function() {
                var segment = $(this).val()
                console.log(segment);
                $.get('getLayers' + segment, function(data) {
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '';
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        select += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    $("#service_layer").html(select);
                });
            });
        });
    </script>
    @endsection

    <script>
        // Esta función maneja los eventos y funcionalidades relacionados con el DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function() {
            // Código para agregar criterios dinámicamente
            const criteriosContainer = document.getElementById('criterios-container');
            const agregarCriterioBtn = document.getElementById('agregar-criterio');
            let contadorCriterios = criteriosContainer.querySelectorAll('textarea').length;

            agregarCriterioBtn.addEventListener('click', function() {
                // Tu lógica para agregar criterios dinámicamente
            });
        });

        // Esta función maneja la inicialización de los plugins de Bootstrap y select2
        $(document).ready(function() {
            // Configuración de select2 para los elementos select con la clase select2-init
            $('.select2-init').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });

            $('[data-toggle="popover"]').popover();

            // Lógica adicional...
        });


        // Inicialización de select2 para los elementos select
        $('#layer, #segment, #quarter, #tAut, #task').select2({
            placeholder: "-- Seleccione --",
            allowClear: true
        });

        // Mostrar mensaje de éxito con Toastr
        toastr.success('¡La iniciativa se ha guardado con éxito! recuerde consultarla mediante el ID: XXXX');
        
    </script>