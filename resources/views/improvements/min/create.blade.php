@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de registro de automatizaciones 2021</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Date-Picker', true)
@section('content')
    @can('regImprovement-create')
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
        <form action="{{route('regImprovementMin.store') }}" method="post">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <p>Este formulario permitirá consignar y almacenar las automatizaciones que se planean sean implementadas como mejoras.</p>
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
                                        <option value="{{ $segment->id }}">{{ $segment->name }}</option>
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
                                              maxlength="200" rows="2" required>{{ old('description') }}</textarea>
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
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
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
                                <select class="form-control" name="month" id="month" style="width: 100%;" required>
                                    <option></option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
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
            $('#month').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $("#segment").change(function(){
                var segment = $(this).val()
                $.get('getLayers/'+segment, function(data){
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

