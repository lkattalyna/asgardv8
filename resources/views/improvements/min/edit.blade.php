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
                    <a class="btn btn-sm btn-danger" href="{{ route('regImprovementMin.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>

        @include('layouts.formError')
        <form action="{{ route('regImprovementMin.update', $regImprovementMin->id) }}" method="post">
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
                                        <option value="{{ $segment->id }}" @if($regImprovementMin->segment_id == $segment->id) selected @endif >{{ $segment->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="layer" class="text-center">Capa de servicio</label>
                            </th>
                            <td>
                                <select class="form-control" name="layer" id="layer" style="width: 100%;" required>
                                    <option></option>
                                    @foreach($layers as $layer)
                                        <option value="{{ $layer->id }}" @if($regImprovementMin->layer_id == $layer->id) selected @endif >{{ $layer->name }}</option>
                                    @endforeach
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
                                                maxlength="200" rows="2" required>{{ $regImprovementMin->description }}</textarea>
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
                                <label for="name" class="text-md-right">Nombre del playbook o automatización</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $regImprovementMin->playbook_name }}"
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
                        <tr>
                            <th>
                                <label for="month" class="text-md-right">Mes de entrega</label>
                            </th>
                            <td>
                                <select class="form-control" name="month" id="month" required>
                                    <option value="1" @if($regImprovementMin->end_date == "1") selected @endif>Enero</option>
                                    <option value="2" @if($regImprovementMin->end_date == "2") selected @endif >Febrero</option>
                                    <option value="3" @if($regImprovementMin->end_date == "3") selected @endif>Marzo</option>
                                    <option value="4" @if($regImprovementMin->end_date == "4") selected @endif>Abril</option>
                                    <option value="5" @if($regImprovementMin->end_date == "5") selected @endif>Mayo</option>
                                    <option value="6" @if($regImprovementMin->end_date == "6") selected @endif >Junio</option>
                                    <option value="7" @if($regImprovementMin->end_date == "7") selected @endif>Julio</option>
                                    <option value="8" @if($regImprovementMin->end_date == "8") selected @endif>Agosto</option>
                                    <option value="9" @if($regImprovementMin->end_date == "9") selected @endif>Septiembre</option>
                                    <option value="10" @if($regImprovementMin->end_date == "10") selected @endif>Octubre</option>
                                    <option value="11" @if($regImprovementMin->end_date == "11") selected @endif>Noviembre</option>
                                    <option value="12" @if($regImprovementMin->end_date == "12") selected @endif>Diciembre</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="improvement" class="text-md-right">Registro de automatización asignado</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="number" name="improvement" id="improvement" min="1" max="32767" class="form-control" value="{{ $regImprovementMin->improvement }}"
                                           placeholder="Si no se requiere dejar 0 (cero)"  required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                              title="Ayuda" data-content="Ingrese el ID del registro de automatización generado por la plataforma">
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
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
            $('#layer').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#segment').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $("#segment").change(function(){
                var segment = $(this).val()
                var url = window.location.origin;
                var path = window.location.pathname
                path = path.split('/')
                $.get(url+'/'+path[1]+'/'+path[2]+'/getLayers/'+segment, function(data){
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

