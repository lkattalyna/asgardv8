@extends('adminlte::page') <!--Complemento pagina AdminLTE-->

<!--Seccion Encabezado-->
@section('content_header')
<h1> Formulario de solicitud Nuevas automatizaciones</h1>
<hr>
@stop

@section('plugins.Select2', true) <!--Complemento pagina AdminLTE-->
@section('plugins.Date-Picker', true) <!--Complemento pagina AdminLTE-->

<!--Seccion Pagina-->
@section('content')

<!--regImprovement-create = NUEVA RUTA???? MISMA RUTA??-->
@can('regImprovement-create') <!--Autorización de 'regImprovement-create'?-->

<!--Boton volver a 'improvements.index'-->
<div class="card card-default">
    <div class="card-body">
        <div class="float-sm-right">
            <a class="btn btn-sm btn-danger" href="{{ route('improvements.index')}}">
                <i class="fa fa-reply"></i> Volver
            </a>
        </div>
    </div>
</div>
@include('layouts.formError')

<!--FORMULARIO-->

<!--Accion de formulario: enviar datos a 'improvements.store'-->
<form action="{{route('improvements.store') }}" method="post">
    {!! csrf_field() !!} <!--Token CSRF-->
    <div class="card card-default">
        <div class="card-header with-border">
            <p>Este formulario permitirá consignar y almacenar las solicitudes de las automatizaciones y sus criterios
                de aceptación.</p>
        </div>

        <!--Inicio tabla de formulario-->
        <div class="card-body">
            <table class="table table-bordered table-hover">

                <!--Segmento-->
                <tr>
                    <th>
                        <label for="segment" class="text-center">Segmento</label>
                    </th>
                    <td>
                        <select class="form-control" name="segment" id="segment" style="width: 100%;" required>
                            <option></option>
                            @foreach($segments as $segment)
                            <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <!--Como-->
                <tr>
                    <th>
                        <label for="description" class="text-md-right">Como</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="description" id="description" class="form-control" placeholder="Descripción"
                                maxlength="200" rows="2" required>{{ old('description') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true"
                                    data-placement="left" title="Ayuda" data-content="Texto de YEIMY">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Quiero-->
                <tr>
                    <th>
                        <label for="scope" class="text-md-right">Quiero</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="scope" id="scope" class="form-control"
                                placeholder="Automatizacion requerida" maxlength="200" rows="2"
                                required>{{ old('scope') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true"
                                    data-placement="left" title="Ayuda"
                                    data-content="Por favor consigne claramente los detalles de la automatización que desea solicitar.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Para-->
                <tr>
                    <th>
                        <label for="objetive" class="text-md-right">Para</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="objetive" id="objetive" class="form-control"
                                placeholder="Objetivo de la automatización" maxlength="200" rows="2"
                                required>{{ old('objetive') }}</textarea>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true"
                                    data-placement="left" title="Ayuda"
                                    data-content="Por favor ingrese el objetivo fundamental de la automatización a solicitar.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Descripcion General-->
                <tr>
                    <th>
                        <label for="descriptionG" class="text-md-right">Descripcion General</label> <!--NewVariable-->
                        'descriptionG'
                    </th>
                    <td>
                        <div class="input-group">
                            <textarea name="descriptionG" id="descriptionG" class="form-control"
                                placeholder="Descripcion General" maxlength="200" rows="2"
                                required>{{ old('descriptionG') }}</textarea> <!--NewID and Name 'descriptionG'-->
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="popover" data-html="true"
                                    data-placement="left" title="Ayuda" data-content="Texto de YEIMY">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--Tipo de automatización-->
                <tr>
                    <th>
                        <label for="tAut" class="text-md-right">Tipo de automatización</label>
                    </th>
                    <td>
                        <select class="form-control" name="tAut" id="tAut" style="width: 100%;" required>
                            <option></option>
                            <option value="Acción">Acción</option>
                            <option value="Consulta">Consulta</option>
                        </select>
                    </td>
                </tr>

                <!--Tipo de tarea-->
                <tr>
                    <th>
                        <label for="task" class="text-md-right">Tipo de tarea</label>
                    </th>
                    <td>
                        <select class="form-control" name="task" id="task" style="width: 100%;" required>
                            <option></option>
                            <option value="Administrativa">Administrativa</option>
                            <option value="Implementación">Implementación</option>
                            <option value="Operativa">Operativa</option>
                        </select>
                    </td>
                </tr>

                <!--Insumos
                    En proceso ...-->
            </table>
        </div>

        <!--Envio formulario-->
        <div class="card-footer">
            <!--debe quedar guardada la fecha + hora de la solicitud. luego mensage de confirmación-->
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fa fa-save"></i> Guardar
            </button>

            <!-- ALGO ASI PARA LA FECHA???
            <div class="form-group">
                    <label>Fecha de registro de la automatización</label>
                    <p> {{ $documentation->regImprovement->created_at}}</p>
                    <hr>
            </div>-->

        </div>
    </div>
</form>

@else
@include('layouts.forbidden_1')
@endcan
@stop

<!--JavaScript-->
@section('js')
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();

        $('#segment').select2({
            placeholder: "-- Seleccione --",
            allowClear: true
        });
        $('#layer').select2({
            placeholder: "-- Seleccione --",
            allowClear: true
        });
        //¿#quarter?
        $('#quarter').select2({
            placeholder: "-- Seleccione --",
            allowClear: true
        });
        $('#task').select2({
            placeholder: "-- Seleccione --",
            allowClear: true
        });
        $('#tAut').select2({
            placeholder: "-- Seleccione --",
            allowClear: true
        });
        /*
        Puede servir
        $('#start').datepicker({
            format: 'yyyy-mm-dd',
            startDate: "2020-01-01",
            todayBtn: "linked",
            orientation: "bottom auto",
            language: "es",
            todayHighlight: true,
            autoclose: true,
        })
        */
        $("#segment").change(function () {
            var segment = $(this).val()
            $.get('getLayers/' + segment, function (data) {
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                select = '';
                for (var i = 0; i < data.length; i++) {
                    select += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }
                $("#layer").html(select);
            });
        });
    });
</script>
@endsection