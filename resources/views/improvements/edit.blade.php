@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de registro de automatizaciones</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Date-Picker', true)
@section('content')
    @can('regImprovement-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('improvements.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @if($improvement->approval_status == 0)
            @include('layouts.formError')
            <form action="{{ route('improvements.update', $improvement->id) }}" method="post">
                {!! csrf_field() !!}
                @method('PUT')
                <div class="card card-default">
                    <div class="card-header with-border">
                        <p>Este formulario permitirá editar las automatizaciones que se planean sean implementadas como mejoras.</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>
                                    <label for="segment" class="text-center">Segmento</label>
                                </th>
                                <td>
                                    <select class="form-control" name="segment" id="segment" style="width: 100%;"  required>
                                        <option></option>
                                        @foreach($segments as $segment)
                                            <option value="{{ $segment->id }}" @if($improvement->segment_id == $segment->id) selected @endif >{{ $segment->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="layer" class="text-center">Torre de servicio</label>
                                </th>
                                <td>
                                    <select class="form-control" name="layer" id="layer" style="width: 100%;" required>
                                        <option></option>
                                        @foreach($layers as $layer)
                                            <option value="{{ $layer->id }}" @if($improvement->layer_id == $layer->id) selected @endif >{{ $layer->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="asgard" class="text-center">Debe ser publicado en Asgard</label>
                                </th>
                                <td>
                                    <select class="form-control" name="asgard" id="asgard" style="width: 100%;" required>
                                        <option></option>
                                        <option value="0" @if($improvement->asgard == 0) selected @endif >No</option>
                                        <option value="1" @if($improvement->asgard == 1) selected @endif>Si</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="description" class="text-md-right">Descripción</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <textarea name="description" id="description" class="form-control" placeholder="Descripción"
                                                  maxlength="200" rows="2" required>{{ $improvement->description }}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Por favor proporcione una breve descripción de la automatización a publicar.">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="scope" class="text-md-right">Alcance</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <textarea name="scope" id="scope" class="form-control" placeholder="Alcance"
                                                  maxlength="200" rows="2" required>{{ $improvement->scope }}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Por favor consigne claramente el alcance y/o limitaciones de la automatización a publicar.">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="objetive" class="text-md-right">Objetivo</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <textarea name="objetive" id="objetive" class="form-control" placeholder="Objetivo"
                                                  maxlength="200" rows="2" required>{{ $improvement->objetive }}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Por favor ingrese el objetivo fundamental de la automatización a publicar.">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="tAut" class="text-md-right">Tipo de automatización</label>
                                </th>
                                <td>
                                    <select class="form-control" name="tAut" id="tAut" style="width: 100%;" required>
                                        <option></option>
                                        <option value="Acción" @if($improvement->aut_type == "Acción") selected @endif >Acción</option>
                                        <option value="Consulta" @if($improvement->aut_type == "Consulta") selected @endif>Consulta</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="task" class="text-md-right">Tipo de tarea</label>
                                </th>
                                <td>
                                    <select class="form-control" name="task" id="task" style="width: 100%;" required>
                                        <option></option>
                                        <option value="Administrativa" @if($improvement->task_type == "Administrativa") selected @endif >Administrativa</option>
                                        <option value="Implementación" @if($improvement->task_type == "Implementación") selected @endif >Implementación</option>
                                        <option value="Operativa" @if($improvement->task_type == "Operativa") selected @endif >Operativa</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="start" class="text-md-right">Fecha de inicio del periodo:</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                        </div>
                                        <input type="text" name="start" id="start" class="form-control input-md" value="{{ $improvement->start_date }}"
                                           pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="end" class="text-md-right">Fecha de finalización del periodo:</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                        </div>
                                        <input type="text" name="end" id="end" class="form-control input-md" value="{{ $improvement->end_date }}"
                                               pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="dependence" class="text-center">Depende de automatización</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Si esta es una automatización que pertenece a otra, se debe seleccionar la automatización padre,
                                                    en caso contrario seleccionar No depende">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                        <select class="form-control" name="dependence" id="dependence" required>
                                            <option value="0" @if($improvement->dependence == 0) selected @endif>No depende</option>
                                            @foreach($regImprovements as $regImprovement)
                                                <option value="{{ $regImprovement->id }}" @if($improvement->dependence == $regImprovement->id) selected @endif >{{ $regImprovement->playbook_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="deliverable" class="text-md-right">Entregable</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="deliverable" id="deliverable" class="form-control" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,80}"
                                               placeholder="Reporte"  maxlength="80" value="{{ $improvement->deliverable }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="PDF, Script, Reporte">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="name" class="text-md-right">Nombre del playbook o automatización</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $improvement->playbook_name }}"
                                               pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{11,31}" placeholder="UNX_PH_001_TEST"  maxlength="31" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Segmentos : </br>TR = Transversal </br>EN = Empresas y Negocios </br>PH = Personas y Hogares
                                                  </br>Estandar de nombre: Siempre separado por (_) guión bajo</br>TORRE = 3 Letras - ALFABÉTICO</br>SEGMENTO = 2 Letras - ALFABÉTICO
                                                  </br>ID = 3 números - NUMÉRICO</br>NOMBRE_CORTO = MAX 20 Letras ALFANUMÉRICO">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card card-default">
                    <div class="card-header with-border">
                        <h3 class="card-title">Impacto de la automatización</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>
                                    <label for="frequency" class="text-md-right">Frecuencia de la ejecución</label>
                                </th>
                                <td>
                                    <select class="form-control" name="frequency" id="frequency" style="width: 100%;" required>
                                        <option></option>
                                        <option value="Cada Hora" @if($improvement->frequency == "Cada Hora") selected @endif >Cada Hora</option>
                                        <option value="Diaria" @if($improvement->frequency == "Diaria") selected @endif >Diaria</option>
                                        <option value="Semanal" @if($improvement->frequency == "Semanal") selected @endif >Semanal</option>
                                        <option value="Mensual" @if($improvement->frequency == "Mensual") selected @endif >Mensual</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="fq" class="text-md-right">Cantidad de ejecuciones</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="fq" id="fq" min="1" max="32767" class="form-control" value="{{ $improvement->frequency_times }}"
                                               placeholder="0"  required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Ingrese el número de ejecuciones de la automatización en la frecuencia escogida.">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="customerLevel" class="text-center">Nivel que ejecuta</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Nivel de los responsables actuales de la ejecución de la tarea">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                        <select class="form-control" name="customerLevel" id="customerLevel" style="width: 100%;" required>
                                            <option></option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}" @if($improvement->customer_level_id == $level->id) selected @endif >{{ $level->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="minB" class="text-md-right">Tiempo antes de automatización</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="minB" id="minB" min="1" max="32767" class="form-control" value="{{ $improvement->minutes_before }}"
                                               placeholder="25"  required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Ingrese el tiempo en minutos que lleva actualmente realizar el proceso que se busca automatizar, este tiempo debe ser respeto a 1 (un) CI">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="minA" class="text-md-right">Tiempo después de automatización</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="minA" id="minA" min="1" max="32767" class="form-control" value="{{ $improvement->minutes_after }}"
                                               placeholder="25"  required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Ingrese el tiempo en minutos que tomaría realizar el proceso después de automatizar, este tiempo debe ser respeto a 1 (un) CI">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="min" class="text-md-right">Tiempo optimizado</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="min" id="min" min="1" max="32767" class="form-control" value="{{ $improvement->minutes_total }}"  readonly required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Tiempo en minutos que optimizará la automatización">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <input type="hidden" name="minT" id="minT" value="{{ $improvement->minutes_total }}" required>
                            </tr>
                            <tr>
                                <th>
                                    <label for="customerLevelPost" class="text-center">Nivel que ejecutará</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Nivel de los responsables de la ejecución de la tarea una vez la automatización este finalizada">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                        <select class="form-control" name="customerLevelPost" id="customerLevelPost" style="width: 100%;" required>
                                            <option></option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}" @if($improvement->customer_level_post_id == $level->id) selected @endif>{{ $level->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="goal" class="text-md-right">Total de CI's a intervenir</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="goal" id="goal" min="1" max="32767" class="form-control" value="{{ $improvement->ci_goal }}"
                                               placeholder="25"  required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Ingrese el número de CI's que afectara esta automatización">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
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
        @endif
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
            $('#asgard').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
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
            $('#task').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#tAut').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#frequency').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#customerLevel').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#customerLevelPost').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#start').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2020-01-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            })
            $('#end').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2020-01-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            })
            $("#minA").change(function(){
                minBefore = $("#minB").val()
                if(minBefore == ''){
                    minBefore = 0;
                }
                minAfter = $("#minA").val()
                if(minAfter == ''){
                    minAfter = 0;
                }
                total = minBefore-minAfter;
                if(total > 0){
                    $("#min").val(total);
                    $("#minT").val(total);
                }else{
                    total = 0
                    $("#min").val(total);
                    $("#minT").val(total);
                }
            });
            $("#minB").change(function(){
                minBefore = $("#minB").val()
                if(minBefore == ''){
                    minBefore = 0;
                }
                minAfter = $("#minA").val()
                if(minAfter == ''){
                    minAfter = 0;
                }
                total = minBefore-minAfter;
                if(total > 0){
                    $("#min").val(total);
                    $("#minT").val(total);
                }else{
                    total = 0
                    $("#min").val(total);
                    $("#minT").val(total);
                }
            });
            $("#segment").change(function(){
                var segment = $(this).val()
                var url = window.location.origin;
                $.get(url+'/improvements/getLayers/'+segment, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '';
                    for (var i=0; i<data.length;i++){
                        select+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $("#layer").html(select);
                });
            });
        });
    </script>
@endsection

