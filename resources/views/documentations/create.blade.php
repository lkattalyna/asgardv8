@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de documentación de automatizaciones</h1><hr>
@stop
@section('plugins.Select2', true)
@section('content')
    @can('documentation-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('documentations.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{route('documentations.store', $regImprovement->id) }}" method="post">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <p>Este formulario permitirá consignar y almacenar la documentación básica y relevante
                        de cada una de las automatizaciones publicadas sobre el portal ASGARD.</p>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label class="text-md-right">Id de la automatización</label>
                            </th>
                            <td>
                                {{ $regImprovement->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="text-md-right">Nombre de la automatización</label>
                            </th>
                            <td>
                                {{ $regImprovement->playbook_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="text-md-right">Descripción de la automatización</label>
                            </th>
                            <td>
                                {{ $regImprovement->description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="text-md-right">Objetivo de la automatización</label>
                            </th>
                            <td>
                                {{ $regImprovement->objetive }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="text-md-right">Alcance de la automatización</label>
                            </th>
                            <td>
                                {{ $regImprovement->scope }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="result" class="text-md-right">Resultado esperado</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <textarea name="result" id="result" class="form-control" placeholder="Resultado esperado"
                                              maxlength="200" rows="2" required>{{ old('result') }}</textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                              title="Ayuda" data-content="Por favor describa de manera precisa qué es lo que se espera obtener o conseguir con la automatización a publicar.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="components" class="text-md-right">Componentes</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <textarea name="components" id="components" class="form-control" placeholder="Ej: VMware, SQL Server, Power BI, etc."
                                              maxlength="200" rows="2" required>{{ old('components') }}</textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                              title="Ayuda" data-content="Por favor relacione los componentes tecnológicos que involucra la automatización a publicar.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="consumedService" class="text-md-right">Servicios consumidos</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                              title="Ayuda" data-content="Si no esta registrado el servicio consumido en la lista por favor solicítelo via email
                                               con el responsable de la documentación">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" name="consumedService" id="consumedService" required>
                                        <option selected disabled>-- Seleccione --</option>
                                        @foreach($consumedServices as $consumedService)
                                            <option value="{{ $consumedService->id }}">{{ $consumedService->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="unrelated" class="text-md-right">Capas no relacionadas</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <textarea name="unrelated" id="unrelated" class="form-control" placeholder="Si no se requiere consignar CAPA involucrada, escriba: Ninguna"
                                              maxlength="200" rows="2" required>{{ old('unrelated') }}</textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                              title="Ayuda" data-content="Consigne nombre de la CAPA de servicio involucrada, cuando no esté relacionada en el punto anterior.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="parameterFlag" class="text-md-right">Parámetros</label>
                            </th>
                            <td>
                                <select class="form-control" name="parameterFlag" id="parameterFlag" required>
                                    <option value="0" selected>No</option>
                                    <option value="1">Si</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="parameterTR" style="display: none;">
                            <th>
                                <label for="parameters" class="text-md-right">Nombre de los parámetros</label>
                            </th>
                            <td>
                                <input type="text" name="parameters" id="parameters" class="form-control" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}"
                                       placeholder="Ej: NombreVM, Hora, vCenter, etc." maxlength="100">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="docFlag" class="text-md-right">Se incluirá manual técnico</label>
                            </th>
                            <td>
                                <select class="form-control" name="docFlag" id="docFlag" required>
                                    <option value="0" selected>No</option>
                                    <option value="1">Si</option>
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
            $("#parameterFlag").change(function(){
                var selected = $(this).val();
                if(selected == 0){
                    $("#parameterTR").hide();
                    $("#parameters").hide();
                    $("#parameters").prop('disabled',true);
                }else{
                    $("#parameterTR").show();
                    $("#parameters").show();
                    $("#parameters").prop('disabled',false);
                }
            });
        });
    </script>
@endsection

